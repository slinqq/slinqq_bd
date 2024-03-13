<?php

namespace App\Listeners;

use App\Events\UserDeactivated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class LogoutUserOnDeactivation implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($event)
    {
        // Log out the user if they are currently logged in
        if (Auth::check() && Auth::id() == $event->userId && Auth::user()->token == null) {
            Auth::logout();
        }
    }
}
