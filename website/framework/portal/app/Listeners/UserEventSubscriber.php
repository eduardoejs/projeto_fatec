<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserEventSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );
    }

    public function onUserLogin($event)
    {
        $tokenAccess = md5(date('YmdHms'));
        $user = auth()->user();
        $user->update(['token_access' => $tokenAccess]);
        session()->put('access_token', $tokenAccess);
    }
}
