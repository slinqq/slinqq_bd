<?php

namespace App\Http\Controllers\Authenticated;

use App\Helper\AccessHelper;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CompanyManager;
use App\Models\Member;
use App\Models\User;
use App\Models\Payment;
use App\Models\Section;
use App\Notifications\AllCompanyMembers;
use WisdomDiala\Countrypkg\Models\Country;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;



class CompanyController extends Controller
{

    public function companies()
    {
        try {
            $user = auth()->user();
            if ($user->hasRole('manager')) {
                $companies = CompanyManager::with(['company'])
                    ->where('user_id', auth()->user()->id)
                    ->get();

                // store the companies in a variable
                $companies = $companies->pluck('company');

                return view('authenticated.companies', compact('companies'));
            }
            $companies = auth()->user()->companies;
            return view('authenticated.companies', compact('companies'));
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('error', 'Something went wrong.');
        }
    }

    public function companyAddForm()
    {
        try {
            if (auth()->user()->hasRole('manager')) {
                return redirect()->route('companies')->with('error', 'You are not allowed to add company.');
            }
            $countries = Country::all();
            return view('authenticated.company.add', compact('countries'));
        } catch (\Throwable $th) {
            return redirect()->route('companies')->with('error', 'Something went wrong.');
        }
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasRole('manager')) {
            return redirect()->route('companies')->with('error', 'You are not allowed to add company.');
        }

        $request->validate([
            'name' => 'required|max:255|min:3',
            'contact_no' => 'required|max:255|min:3',
            'address' => 'required|max:255|min:3',
            'city' => 'required',
            'country' => 'required',
        ]);

        try {

            Company::create([
                'name' => $request->name,
                'contact_no' => $request->contact_no,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'user_id' => auth()->user()->id,
            ]);

            return redirect()->route('companies')->with('success', 'Building added successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('companies')->with('error', 'Something went wrong.');
        }
    }

    public function show(Request $request, $companyId)
    {
        if (auth()->user()->hasRole('manager')) {
            $access = AccessHelper::hasManagerAccess(auth()->user(), $companyId);

            if (!$access) {
                return redirect()->route('companies')->with('error', 'You are not allowed to access this company.');
            }
        }

        $paymentFilter = $request->query('payment');
        $memberFilter = $request->query('member');
        $memberID = $request->search;

        try {

            $company = Company::findOrFail($companyId);

            $sections = Section::with([
                'members' => function ($query) use ($paymentFilter, $memberFilter, $memberID) {
                    $query->where(function ($query) use ($paymentFilter, $memberFilter, $memberID) {
                        if ($paymentFilter === 'paid') {
                            $query->whereHas('currentMonthPayment', function ($paymentQuery) {
                                $paymentQuery->where('payment_for_month', Carbon::now()->format('Y-m'))
                                    ->where('status', 'Paid');
                            });
                        } elseif ($paymentFilter === 'unpaid') {
                            $query->whereDoesntHave('currentMonthPayment', function ($paymentQuery) {
                                $paymentQuery->where('payment_for_month', Carbon::now()->format('Y-m'));
                            });
                        } elseif ($memberFilter === 'empty') {
                            $query->where('status', 'inactive');
                        } elseif ($memberID != null) {
                            $query->where('member_id', $memberID);
                        }
                    });
                },
            ])->where('company_id', $company->id)->get();

            return view('authenticated.company.manage', compact('company', 'sections'));
        } catch (\Throwable $th) {
            return redirect()->route('companies')->with('error', 'Something went wrong.');
        }
    }


    public function notificationCompaniesAll()
    {
        return view('authenticated.company.notification.notification-companies-all');
    }

    public function notificationCompaniesAllSend(Request $request)
    {

        $request->validate([
            'message' => 'required|min:3',
            'subject' => 'required|min:5',
            'attachment' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        try {

            $sender = auth()->user();
            $role = $sender->roles()->first()->name;
            if ($role == 'manager') {
                $companies = CompanyManager::with(['company'])
                    ->where('user_id', auth()->user()->id)
                    ->get();

                $companies = $companies->pluck('company');
                //return companies with sections and members
                $companies = Company::with(['sections', 'sections.members'])->whereIn('id', $companies->pluck('id'))->get();
            } else {
                //return companies with sections and members for auth user
                $companies = Company::with(['sections', 'sections.members'])->where('user_id', auth()->user()->id)->get();
            }

            if ($companies->count() == 0) {
                return redirect()->route('companies')->with('error', 'You have no companies.');
            }
            $members = [];

            foreach ($companies as $company) {
                foreach ($company->sections as $section) {
                    foreach ($section->members as $member) {
                        if ($member->status == 'active') {
                            $members[] = $member;
                        }
                    }
                }
            }

            if (count($members) == 0) {
                return redirect()->route('companies')->with('error', 'You have no active members.');
            }

            $attachmentPath = null;

            if ($request->hasFile('attachment')) {
                $attachment = $request->file('attachment');
                $attachmentPath = $attachment->store('attachments', 'public');
            }
            // Pass the extracted information to the notification
            Notification::send($members, new AllCompanyMembers($request->message, $request->subject, $attachmentPath, $sender));
            return redirect()->route('companies')->with('success', 'Notification sent successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('companies')->with('error', 'Something went wrong.');
        }
    }

    public function notificationCompanyAll($companyId)
    {
        if (auth()->user()->hasRole('manager')) {
            AccessHelper::hasManagerAccess(auth()->user(), $companyId);
        }

        try {
            return view('authenticated.company.notification.notification-all');
        } catch (\Throwable $th) {
            return redirect()->route('company.manage', ['companyId' => $companyId])->with('error', 'Something went wrong.');
        }
    }

    public function notificationAllSend(Request $request, $companyId)
    {
        if (auth()->user()->hasRole('manager')) {
            AccessHelper::hasManagerAccess(auth()->user(), $companyId);
        }

        $request->validate([
            'message' => 'required|min:3',
            'subject' => 'required|min:5',
            'attachment' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        try {

            $sections = Company::findOrFail($companyId)->sections()->with('members')->get();
            $sender = auth()->user();
            $members = [];
            foreach ($sections as $section) {
                foreach ($section->members as $member) {
                    if ($member->status == 'active') {
                        $members[] = $member;
                    }
                }
            }

            if (count($members) == 0) {
                return redirect()->route('company.manage', ['companyId' => $companyId])->with('error', 'You have no active members.');
            }

            $attachmentPath = null;

            if ($request->hasFile('attachment')) {
                $attachment = $request->file('attachment');
                $attachmentPath = $attachment->store('attachments', 'public');
            }
            // Pass the extracted information to the notification
            Notification::send($members, new AllCompanyMembers($request->message, $request->subject, $attachmentPath, $sender));
            return redirect()->route('company.manage', ['companyId' => $companyId])->with('success', 'Notification sent successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('company.manage', ['companyId' => $companyId])->with('error', 'Something went wrong.');
        }
    }

    public function notificationCompanySpecificMember($memberId)
    {
        try {
            $sender = auth()->user();
            if ($sender->hasRole('superadmin')) {
                $member = User::findOrFail($memberId);
            } else {
                $member = Member::findOrFail($memberId);
            }
            return view('authenticated.company.notification.notification-specific-member', compact('member'));
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
        }
    }

    public function notificationCompanySpecificMemberSend(Request $request, $memberId)
    {

        $request->validate([
            'message' => 'required|min:3',
            'subject' => 'required|min:5',
            'attachment' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        try {

            $sender = auth()->user();
            if ($sender->hasRole('superadmin')) {
                $member = User::findOrFail($memberId);
            } else {
                $member = Member::findOrFail($memberId);
            }

            if ($member->status == 'inactive') {
                return back()->with('error', 'Member is inactive.');
            }

            $attachmentPath = null;

            if ($request->hasFile('attachment')) {
                $attachment = $request->file('attachment');
                $attachmentPath = $attachment->store('attachments', 'public');
            }
            // Pass the extracted information to the notification
            $member->notify(new AllCompanyMembers($request->message,  $request->subject, $attachmentPath, $sender));

            return back()->with('success', 'Notification sent successfully.');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
        }
    }

    public function CheckPaymentCollection()
    {
        try {
            $user = auth()->user();

            if ($user->hasRole('manager')) {
                $companies = CompanyManager::with(['company'])
                    ->where('user_id', $user->id)
                    ->get();

                $userCompanies = $companies->pluck('company');
            } else {
                // Get all companies of the user (admin or superadmin
                $userCompanies = $user->companies()->get();
            }

            $memberIds = Member::whereIn('company_id', $userCompanies->pluck('id'))->pluck('id');


            $statistics = Member::whereIn('members.company_id', $userCompanies->pluck('id'))
                ->where('members.status', 'active')
                ->leftJoin('payments', function ($join) {
                    $join->on('members.id', '=', 'payments.member_id')
                        ->where('payments.payment_for_month', now()->format('Y-m'));
                })
                ->selectRaw('
            SUM(payments.amount) as totalMonthlyEarnings,
            SUM(CASE WHEN payments.status = "Paid" THEN 1 ELSE 0 END) as paidMembersCount,
            SUM(CASE WHEN payments.id IS NULL THEN 1 ELSE 0 END) as unpaidMembersCount')
                ->first();

            $totalAnnualEarnings = Payment::whereRaw("SUBSTRING_INDEX(payment_for_month, '-', 1) = ?", [now()->format('Y')])
                ->whereIn('member_id', $memberIds)
                ->where('status', 'Paid')
                ->sum('amount');

            // Add totalAnnualEarnings to the statistics
            $statistics->totalAnnualEarnings = $totalAnnualEarnings;

            // Separate query for totalEarningsPaid
            $totalEarningsPaid = Payment::whereIn('member_id', $memberIds)
                ->where('status', 'Paid')
                ->sum('amount');

            // Add totalEarningsPaid to the statistics
            $statistics->totalEarningsPaid = $totalEarningsPaid;

            return view('authenticated.company.payment.payment-collection', $statistics);
        } catch (\Throwable $th) {
            return redirect()->route('companies')->with('error', 'Something went wrong.');
        }
    }
}
