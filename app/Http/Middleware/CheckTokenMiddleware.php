<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->token == null) {
            auth()->logout();

            return redirect()->route('login.index')->with('error', 'you account has been blocked by the authority. Please contact on the email - sayeedakib6009@gmail.com.');
        }

        return $next($request);
    }
}
