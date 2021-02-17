<?php

namespace Gamify\Listeners;

use Gamify\Models\Badge;
use Gamify\Enums\BadgeActuators;
use Gamify\Libs\Game\Game;
use Gamify\Models\User;
use Illuminate\Auth\Events\Login;

class IncrementBadgesOnUserLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \Illuminate\Auth\Events\Login $event
     *
     * @return void
     */
    public function handle(Login $event)
    {
        $user = User::findOrFail($event->user->getAuthIdentifier());
        $badges = Badge::whereActuators(BadgeActuators::OnUserLogin)->get();
        Game::incrementManyBadges($user, $badges);
    }
}
