<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use WisdomDiala\Countrypkg\Models\Country;
use Illuminate\Support\Str;
use App\Notifications\VerifyEmailNotification;

class SignupController extends Controller
{
    public function index(Request $request)
    {
        try {
            if (auth()->check()) {
                if (auth()->user()->hasRole('user'))
                    return redirect()->route('home');
                else
                    return redirect()->route('companies');
            }
            $countries = Country::all();
            $query = $request->query('requestUrl');
            $routeName = $request->query('routeName');
            return view('auth.signup', compact('countries', 'query', 'routeName'));
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Error creating user.'])->withInput();
        }
    }

    public function store(Request $request)
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
            'user_type' => 'required|in:admin,user',
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
            ]);

            if (!$user) {
                return back()->withErrors(['error' => 'Error creating user.'])->withInput();
            }

            $role = Role::where('name', $request->user_type)->first();
            $user->assignRole($role);

            // send email verification
            $token = Str::random(60);
            $user->remember_token = $token;
            $user->save();
            $user->notify(new VerifyEmailNotification($token));
            // Redirect to the home page
            return redirect()->route('home')->with('success', 'Account created successfully. Please check your email for verification.');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Error creating user.'])->withInput();
        }
    }
}
