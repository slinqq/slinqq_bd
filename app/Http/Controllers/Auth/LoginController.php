<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ForgotPasswordNotification;
use App\Notifications\ResetPasswordSuccessNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoginController extends Controller
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

            $query = $request->query('requestUrl');
            $query = $request->query('requestUrl');

            return view('auth.login', compact('query'));
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
        }
    }

    public function checkCredentials(Request $request)
    {

        // Validate the user
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()->withErrors(['error' => 'User not found!'])->withInput();
            }

            //check user role is only user or not
            $roles = $user->roles->pluck('name');

            if ($roles->count() == 1 && $user->status != 'active') {
                $token = Str::random(60);
                $user->remember_token = $token;
                $user->save();
                $user->notify(new VerifyEmailNotification($token));
                return back()->withErrors(['error' => 'Your account is not verified yet. Please check your email for verification link.'])->withInput();
            }

            // Sign the user in
            if (!auth()->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 'active'])) {
                return back()->withErrors(['error' => 'Invalid password!'])->withInput();
            }

            if ($user->is_blocked) {
                auth()->logout();
                return back()->withErrors(['error' => 'you account has been blocked by the authority. Please contact on the email - sayeedakib6009@gmail.com.'])->withInput();
            }

            $token = Str::random(60); // Generate a random token
            auth()->user()->update(['token' => $token]);
            // $request->headers->set('Authorization', $token);

            // Check if user is superadmi,admin or user
            if ($user->hasRole('user')) {
                $queryUrl = $request['query'];
                if ($queryUrl == null) {
                    return redirect()->route('home')->with('success', 'You are now logged in.');
                }

                // Extract the ID from the URL
                $segments = explode('/', $queryUrl);
                $companyId = end($segments);

                return redirect()->route('companies.emptyposition.search.details', ['companyId' => $companyId])->with('success', 'You are now logged in.');
            }

            if ($user->hasRole('superadmin')) {
                return redirect()->route('superadmin')->with('success', 'You are now logged in.');
            }

            return redirect()->route('companies')->with('success', 'You are now logged in.');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
        }
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPasswordStore(Request $request)
    {
        // Validate the user
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        try {

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()->withErrors(['error' => 'No user found with this email address.'])->withInput();
            }

            $token = DB::table('password_reset_tokens')->where('email', $user->email)->first();

            if ($token) {
                DB::table('password_reset_tokens')->where('email', $user->email)->delete();
            }

            //Generate a token
            $token = Crypt::encryptString($user->email);
            // save token in database
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);

            $user->notify(new ForgotPasswordNotification($token));

            return back()->with('success', 'A password reset link has been sent to your email address.');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
        }
    }

    public function forgotPasswordUpdateForm($token)
    {
        try {
            $token = DB::table('password_reset_tokens')->where('token', $token)->first();

            if (!$token) {
                return redirect()->route('forgot-password')->withErrors(['error' => 'Invalid token.']);
            }

            // check if token is expired
            $tokenCreatedAt = Carbon::parse($token->created_at);
            $now = Carbon::now();
            $diff = $tokenCreatedAt->diffInMinutes($now);

            if ($diff > 60) {
                DB::table('password_reset_tokens')->where('email', $token->email)->delete();
                return redirect()->route('forgot-password')->withErrors(['error' => 'Token expired. Please try again.'])->withInput();
            }

            return view('auth.forgot-password-update', ['token' => $token->token]);
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
        }
    }


    public function forgotPasswordUpdate(Request $request, $token)
    {

        // Validate the user
        $this->validate($request, [
            'password' => 'required|confirmed',
        ]);

        try {

            $token = DB::table('password_reset_tokens')->where('token', $token)->first();

            if (!$token) {
                return back()->withErrors(['error' => 'Invalid token.'])->withInput();
            }

            // check if token is expired
            $tokenCreatedAt = Carbon::parse($token->created_at);
            $now = Carbon::now();
            $diff = $tokenCreatedAt->diffInMinutes($now);

            if ($diff > 60) {
                DB::table('password_reset_tokens')->where('email', $token->email)->delete();
                return back()->withErrors(['error' => 'Token expired. Please try again.'])->withInput();
            }

            $user = User::where('email', $token->email)->first();

            if (!$user) {
                return back()->withErrors(['error' => 'No user found with this email address.'])->withInput();
            }

            $user->password = bcrypt($request->password);
            $user->save();

            DB::table('password_reset_tokens')->where('email', $user->email)->delete();

            $user->notify(new ResetPasswordSuccessNotification());

            return redirect()->route('login.index')->with('success', 'Password reset successful. You can now login with your new password.');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
        }
    }

    public function verify($id, $hash)
    {
        try {
            $user = User::findOrFail($id);

            if (!$user) {
                return redirect()->route('login.index')->withErrors(['error' => 'No user found with this email address.'])->withInput();
            }

            if ($hash == $user->remember_token) {
                $user->email_verified_at = Carbon::now();
                $user->status = 'active';
                $user->remember_token = null;
                $user->save();
                return redirect()->route('login.index')->with('success', 'Email verification successful. You can now login.');
            }

            return redirect()->route('login.index')->withErrors(['error' => 'Invalid token.']);
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
        }
    }

    public function logout()
    {
        try {
            auth()->user()->update(['token' => null]);
            auth()->logout();
            return redirect()->route('home');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Something went wrong.'])->withInput();
        }
    }
}
