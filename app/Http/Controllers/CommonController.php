<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use WisdomDiala\Countrypkg\Models\Country;
use WisdomDiala\Countrypkg\Models\State;
use Spatie\Sitemap\SitemapGenerator;
use Illuminate\Support\Facades\Route;


class CommonController extends Controller
{

    public function home()
    {
        return view('home.index');
    }

    public function getCities($id)
    {
        try {
            $country = Country::where('name', $id)->first();
            $cities = State::where('country_id', $country->id)->pluck('name');
            return response()->json($cities);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong.']);
        }
    }

    public function getSearchCompanies(Request $request)
    {
        try {
            // // chekc if user is logged in
            // if ($request->query('query') && !auth()->check()) {
            //     return redirect()->route('login.index', ['query' => $request->query('query')]);
            // }

            $searchTerm = $request->query('query');
            $companies = Company::whereHas('members', function ($query) use ($searchTerm) {
                $query->where('status', 'inactive');
            })
                ->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('address', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('city', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('country', 'LIKE', '%' . $searchTerm . '%');
                })
                ->get();

            return view('home.empty-companies', compact('companies'));
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
        }
    }

    public function getSearchCompanyDetails($companyId)
    {
        try {
            $company = Company::findOrFail($companyId);

            // Eager load members with inactive status
            $company->load(['members' => function ($query) {
                $query->where('status', 'inactive');
            }, 'sections' => function ($query) {
                $query->withCount('members');
            }]);

            $emptySectionId = [];
            foreach ($company->members as $key => $member) {
                if ($member->status == 'inactive') {
                    $emptySectionId[] = $member->section_id;
                }
            }

            $emptySectionId = array_unique($emptySectionId);

            $emptySections = $company->sections->whereIn('id', $emptySectionId);

            return view('home.empty-company-details', compact('company', 'emptySections'));
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
        }
    }

    public function about()
    {
        return view('home.about');
    }

    public function service()
    {
        return view('home.service');
    }

    public function downloadAttachment($filename)
    {
        try {
            //return $filename;
            $filePath = public_path('storage/attachments/' . $filename);

            if (file_exists($filePath)) {
                return response()->download($filePath);
            }

            return redirect()->back()->with('error', 'File not found!');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
        }
    }

    public function terms()
    {
        return view('home.terms');
    }

    public function generateSitemap()
    {
        try {
            // Create a Sitemap instance
            $sitemap = SitemapGenerator::create(config('app.url'))->getSitemap();

            // Get all registered routes
            $routes = Route::getRoutes();

            // Loop through the routes and add them to the sitemap
            foreach ($routes as $route) {
                $uri = $route->uri();
                $sitemap->add(url($uri)); // Use url() to make sure the full URL is added
            }

            // Write the sitemap to the specified file
            $sitemap->writeToFile(public_path('sitemap.xml'));

            return redirect()->route('home')->with('success', 'Sitemap generated successfully!');
        } catch (\Throwable $th) {
            dd($th);
            return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
        }
    }
}
