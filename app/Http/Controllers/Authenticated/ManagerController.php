<?php

namespace App\Http\Controllers\Authenticated;

use App\Http\Controllers\Controller;
use App\Models\CompanyManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use WisdomDiala\Countrypkg\Models\Country;

class ManagerController extends Controller
{
    public function managerAssignToCompany(Request $request)
    {
        try {
            $companyId = $request->query('companyId');
            $countries = Country::all();
            return view('authenticated.managers.create', compact('countries', 'companyId'));
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
        }
    }

    public function managerAssignToCompanyStore(Request $request)
    {

        // Validate the user
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|numeric',
            'address' => 'required|max:255',
            'city' => 'required|max:255',
            'country' => 'required|max:255',
            'password' => 'required|confirmed',
        ]);

        try {

            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'password' => Hash::make($request->password),
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            $user->assignRole('manager');
            $user->givePermissionTo('manage-company');

            if ($request->companyId) {
                $user->companiesManager()->attach($request->companyId, ['company_admin_user_id' => auth()->user()->id]);
            } else {
                $companies = auth()->user()->companies;
                foreach ($companies as $company) {
                    $user->companiesManager()->attach($company->id, ['company_admin_user_id' => auth()->user()->id]);
                }
            }

            return redirect()->route('managers')->with('success', 'Manager assigned successfully');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Error creating user.'])->withInput();
        }
    }

    public function managers()
    {
        try {
            // Get managers for all companies with company information
            $managers = CompanyManager::with(['user', 'company'])
                ->where('company_admin_user_id', auth()->user()->id)
                ->get();


            return view('authenticated.managers.index', compact('managers'));
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('error', 'Something went wrong');
        }
    }

    public function reAssignToCompany(User $user)
    {
        try {
            $companies = auth()->user()->companies;
            return view('authenticated.managers.reassign', compact('user', 'companies'));
        } catch (\Throwable $th) {
            return redirect()->route('managers')->with('error', 'Something went wrong');
        }
    }

    public function reAssignToCompanyStore(Request $request, $userId)
    {

        $this->validate($request, [
            'company' => 'required',
        ]);

        try {


            $company = CompanyManager::where([['company_id', $request->company], ['user_id', $userId], ['company_admin_user_id', auth()->user()->id]])->first();

            if ($company) {
                return back()->with('error', 'Manager already assigned to this building');
            }

            $user = User::find($userId);

            $user->companiesManager()->attach($request->company, ['company_admin_user_id' => auth()->user()->id]);

            return redirect()->route('managers')->with('success', 'Manager assigned successfully');
        } catch (\Throwable $th) {
            return redirect()->route('managers')->with('error', 'Something went wrong');
        }
    }

    public function managerRemove($managerId)
    {
        try {
            $manager = CompanyManager::find($managerId);
            $user = $manager->user;

            //check if user is assigned manager role
            if (!$user->hasRole('manager')) {
                return back()->with('error', 'Manager role not assigned to this user');
            }

            if ($manager->company_admin_user_id != auth()->user()->id) {
                return back()->with('error', 'You are not authorized to perform this action');
            }

            //remove manager role from user


            //remove permission from user
            $user->revokePermissionTo('manage-company');

            //remove manager from company
            $manager->delete();

            //check if user has any other company
            $companies = CompanyManager::where('user_id', $user->id)->get();
            if ($companies->count() == 0) {
                $user->removeRole('manager');
                $user->delete();
            }

            return back()->with('success', 'Manager role removed successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong');
        }
    }
}
