<?php

namespace Gamify\Listeners;

use Gamify\Badge;
use Gamify\Enums\BadgeActuators;
use Gamify\Events\QuestionAnswered;
use Gamify\Libs\Game\Game;
use Gamify\User;

class IncrementBadgesOnQuestionAnswered
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
     * @param \Gamify\Events\QuestionAnswered $event
     *
     * @return void
     */
    public function handle(QuestionAnswered $event)
    {
        $user = User::findOrFail($event->user->getAuthIdentifier());
        $badges = Badge::whereIn('actuators', [
            BadgeActuators::OnQuestionAnswered,
            ($event->correctness === true)
                ? BadgeActuators::OnQuestionCorrectlyAnswered
                : BadgeActuators::OnQuestionIncorrectlyAnswered,
            ])->get();

        // TODO: badges associated to questions

        Game::incrementManyBadges($user, $badges);
    }
}
