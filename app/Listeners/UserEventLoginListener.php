<?php

namespace Gamify\Listeners;

use Carbon\Carbon;
use Gamify\User;

class UserEventLoginListener
{
    /**
     * Handle the event.
     *
     * @param User $user
     *
     * @return void
     */
    public function handle(User $user, $remember)
    {
        $user->last_login = Carbon::now();
        $user->save();
    }
}
