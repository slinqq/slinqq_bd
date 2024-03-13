<?php

namespace App\Http\Controllers\Authenticated;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function sectionAdd($companyId)
    {
        try {
            $company = Company::findOrFail($companyId);
            return view('authenticated.company.section.add', compact('company'));
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function sectionStore(Request $request, $companyId)
    {
        $request->validate([
            'title' => 'required|max:255|min:3',
        ]);

        try {
            $company = Company::findOrFail($companyId);
            $company->sections()->create([
                'title' => $request->title,
            ]);

            return redirect()->route('company.manage', ['companyId' => $company->id])->with('success', 'Floor added successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function sectionDelete(Request $request, $companyId)
    {
        $request->validate([
            'sectionId' => 'required',
        ]);

        try {

            $company = Company::findOrFail($companyId);
            $section = Section::findOrFail($request->sectionId);

            //remove members from section
            $section->members()->delete();
            //remove section
            $company->sections()->where('id', $request->sectionId)->delete();

            return redirect()->route('company.manage', ['companyId' => $company->id])->with('success', 'Floor deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('company.manage', ['companyId' => $company->id])->with('error', 'Something went wrong.');
        }
    }
}
