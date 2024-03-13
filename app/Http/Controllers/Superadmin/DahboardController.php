<?php

namespace App\Http\Controllers\Superadmin;

use App\Events\UserDeactivated;
use App\Http\Controllers\Controller;
use App\Models\CompanyManager;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DahboardController extends Controller
{
    public function ()
    {
        try {
            // Retrieve the  role
            $adminRole = Role::where('name', 'admin')->first();

            // Retrieve all users with the admin role along with roles
            $admins = User::whereHas('roles', function ($query) use ($adminRole) {
                $query->where('name', $adminRole->name);
            })->with('roles')->get();

            return view('authenticated.superadmin.dashboard', compact('admins'));
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('error', 'Something went wrong');
        }
    }

    public function manageAdminUser($userId)
    {
        // Retrieve the user with the given id along with companies
        try {
            $user = User::with('companies.members')->findOrFail($userId);

            return view('authenticated.superadmin.manage', compact('user'));
        } catch (\Throwable $th) {
            return redirect()->route('superadmin')->with('error', 'Something went wrong');
        }
    }

    public function updateAdminUser($userId)
    {
        try {
            // Retrieve the user with the given id
            $user = User::findOrFail($userId);

            // Toggle the user status
            $user->is_blocked = ($user->is_blocked == 0) ? 1 : 0;

            // Dispatch the UserDeactivated event if the user is now inactive
            if ($user->is_blocked == 1) {
                $user->token = null;
                event(new UserDeactivated($user->id));
            }

            // Update the user
            $user->save();

            CompanyManager::where('company_admin_user_id', $userId)
                ->get()
                ->each(function ($manager) use ($user) {
                    $manager->user->status = $user->status;
                    if ($user->is_blocked == 1) {
                        $manager->user->token = null;
                        $manager->user->is_blocked = true;
                    } else {
                        $manager->user->is_blocked = false;
                    }
                    $manager->user->save();
                });
            // Redirect to the manage admin user page
            return redirect()->route('superadmin.manage', ['userId' => $user->id])->with('success', 'Admin user updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('superadmin.manage', ['userId' => $user->id])->with('error', 'Something went wrong');
        }
    }
}
