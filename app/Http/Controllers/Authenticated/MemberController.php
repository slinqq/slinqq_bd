<?php

namespace App\Http\Controllers\Authenticated;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Section;
use App\Notifications\PaymentSuccessNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function memberAdd($companyId, $sectionId)
    {
        try {
            $company = Company::findOrFail($companyId);
            $section = Section::findOrFail($sectionId);
            return view('authenticated.company.member.add', compact('company', 'section'));
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function memberStore(Request $request, $companyId, $sectionId)
    {

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email',
            'contact_no' => 'required|max:255',
            'address' => 'required|max:255',
            'occupation' => 'required|max:255',
            'member_id' => 'required|max:255',
            'monthly_fee' => 'required|max:15',
            'join_date' => 'required',
            'advance_amount' => 'required|max:15',
        ]);

        try {

            $company = Company::findOrFail($companyId);
            $section = Section::findOrFail($sectionId);

            Member::create([
                'name' => $request->name,
                'email' => $request->email,
                'contact_no' => $request->contact_no,
                'address' => $request->address,
                'occupation' => $request->occupation,
                'member_id' => $request->member_id,
                'monthly_fee' => $request->monthly_fee,
                'join_date' => $request->join_date,
                'company_id' => $company->id,
                'section_id' => $section->id,
                'status' => 'active',
                'advance_amount' => $request->advance_amount,
            ]);


            return redirect()->route('company.manage', ['companyId' => $company->id])->with('success', 'Flat added successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function memberEdit($companyId, $sectionId, $memberId)
    {
        try {
            $company = Company::findOrFail($companyId);
            $section = Section::findOrFail($sectionId);
            $member = Member::findOrFail($memberId);
            $payments = $member->payments;

            return view('authenticated.company.member.edit', compact('company', 'section', 'member', 'payments'));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function memberUpdate(Request $request, $companyId, $sectionId, $memberId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|max:255|email',
            'contact_no' => 'required|max:255',
            'address' => 'required|max:255',
            'occupation' => 'required|max:255',
            'member_id' => 'required|max:255',
            'monthly_fee' => 'required|max:15',
            'join_date' => 'required',
            'advance_amount' => 'required|max:15',
        ]);

        if ($validator->fails()) {
            // Return validation errors as JSON response
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $company = Company::findOrFail($companyId);
        $section = Section::findOrFail($sectionId);
        $member = Member::findOrFail($memberId);

        try {
            $member->update([
                'name' => $request->name,
                'email' => $request->email,
                'contact_no' => $request->contact_no,
                'address' => $request->address,
                'occupation' => $request->occupation,
                'member_id' => $request->member_id,
                'monthly_fee' => $request->monthly_fee,
                'join_date' => $request->join_date,
                'company_id' => $company->id,
                'section_id' => $section->id,
                'advance_amount' => $request->advance_amount,
                'status' => 'active',
            ]);

            // Return a success response
            return response()->json(['message' => 'Flat updated successfully'], 200);
        } catch (\Exception $e) {
            // Return an error response with the exception message
            return response()->json(['error' => 'Failed to update member', 'message' => $e->getMessage()], 500);
        }
    }

    public function memberDelete($companyId, $sectionId, $memberId)
    {
        try {
            $member = Member::findOrFail($memberId);

            //update all values to null
            $member->update([
                'name' => null,
                'email' => null,
                'contact_no' => null,
                'address' => null,
                'occupation' => null,
                'monthly_fee' => null,
                'join_date' => null,
                'status' => 'inactive',
            ]);

            return back()->with('success', 'Flat member cleared successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function memberPaymentAdd($companyId, $sectionId, $memberId)
    {
        try {
            $member = Member::findOrFail($memberId);
            $company = $member->company;
            $section = $member->section;

            $currentYear = date('Y'); // Get the current year
            $months = [];

            // Loop through each month and create an object for each
            for ($month = 1; $month <= 12; $month++) {
                $monthName = date('F', mktime(0, 0, 0, $month, 1)); // Get month name
                $formattedMonth = sprintf('%04d-%02d', $currentYear, $month); // Format month as 'YYYY-MM'

                $months[] = [
                    'name' => $monthName,
                    'value' => $formattedMonth,
                ];
            }
            return view('authenticated.company.member.member-payment-add', compact('member', 'company', 'section', 'months'));
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function memberPaymentStore(Request $request, $companyId, $sectionId, $memberId)
    {

        $request->validate([
            'amount' => 'required|max:255|min:3',
            'currency' => 'required|max:255|min:3',
            'payment_method' => 'required|max:255|min:3',
            'payment_date' => 'required',
            'payment_for_month' => 'required',
        ]);

        try {
            $sender = auth()->user();
            $member = Member::findOrFail($memberId);
            if ($member->status == 'inactive') {
                return back()->with('error', 'Flat is empty.');
            }
            $payment = Payment::where('member_id', $member->id)->where('payment_for_month', $request->payment_for_month)->first();

            if ($payment) {
                return back()->with('error', 'Payment already added for this month.');
            }

            $company = $member->company;
            $section = $member->section;

            $response = $member->payments()->create([
                'amount' => $request->amount,
                'currency' => $request->currency,
                'payment_method' => $request->payment_method,
                'payment_date' => $request->payment_date,
                'payment_for_month' => $request->payment_for_month,
                'status' => 'Paid',
                'company_id' => $company->id,
                'member_name' => $member->name,
                'contact_no' => $member->contact_no,
                'email' => $member->email,
            ]);

            if (!$response) {
                return back()->with('error', 'Failed to add payment.');
            }

            //send email
            $data = [
                'name' => $member->name,
                'amount' => $response->amount,
                'currency' => $response->currency,
                'payment_method' => $response->payment_method,
                'payment_date' => $response->payment_date,
                'payment_for_month' => $response->payment_for_month,
                'company_name' => $company->name,
                'payment_id' => $response->id,
                'section_id' => $section->id,
                'sender' => $sender,
            ];


            $member->notify(new PaymentSuccessNotification($data));

            return redirect()->route('member.edit', ['companyId' => $company->id, 'sectionId' => $sectionId, 'memberId' => $member->id])->with('success', 'Payment added successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong.');
        }
    }

    //memberPaymentRemove
    public function memberPaymentRemove($companyId, $sectionId, $memberId, $paymentId)
    {
        try {
            $payment = Payment::findOrFail($paymentId);
            $payment->delete();
            return back()->with('success', 'Payment removed successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function downloadInvoicePdf($paymentId, $section_id)
    {

        $payment = Payment::findOrFail($paymentId);
        if (!$payment) {
            return redirect()->route('home')->with('error', 'Payment not found.');
        }

        $member = $payment->member;
        $section = Section::findOrFail($section_id);

        if (!$section) {
            return redirect()->route('home')->with('error', 'Flat not found.');
        }
        $company = $section->company;

        if (!$company) {
            return redirect()->route('home')->with('error', 'Company not found.');
        }


        $invoiceData = [
            'payment' => $payment,
            'building' => $company,
            'floor' => $section,
            'flat' => $member,
        ];

        // Generate PDF using the retrieved data
        $pdf = PDF::loadView('pdf.invoice', compact('invoiceData'));

        // Download the PDF
        return $pdf->download(
            'payment-' . $payment->payment_for_month . '-' . $company->name . '-' . $section->name . '-' . $member->name . '.pdf'
        );
    }
}
