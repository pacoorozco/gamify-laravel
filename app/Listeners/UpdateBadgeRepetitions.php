<?php

namespace Gamify\Listeners;

use Gamify\Events\QuestionAnswered;
use Gamify\Libs\Game\Game;

class UpdateBadgeRepetitions
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
     * @param QuestionAnswered $event
     *
     * @return void
     */
    public function handle(QuestionAnswered $event)
    {
        $badges = $event->question->getActionableBadgesForCorrectness($event->answerCorrectness);
        Game::incrementManyBadges($event->user, $badges);
    }
}
