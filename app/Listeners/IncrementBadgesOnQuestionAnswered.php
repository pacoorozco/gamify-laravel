<?php

namespace Gamify\Listeners;

use Gamify\Models\Badge;
use Gamify\Enums\BadgeActuators;
use Gamify\Events\QuestionAnswered;
use Gamify\Libs\Game\Game;
use Gamify\Models\User;

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

        $badges = $badges->merge(
            $event->question->getActionableBadgesForCorrectness($event->correctness)
        );

        Game::incrementManyBadges($user, $badges);
    }
}
