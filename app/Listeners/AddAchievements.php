<?php

namespace Gamify\Listeners;

use Gamify\Events\QuestionAnswered;
use Gamify\Libs\Game\Game;

class AddAchievements
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
        // TODO: Get all the achievements with QuestionAnswered, QuestionCorrectlyAnswered and QuestionIncorrectlyAnswered.

        // Get all the achievements associated with the Question and QuestionsAnswered, QuestionCorrectlyAnswered and QuestionIncorrectlyAnswered.
        $badges = $event->question->getActionableBadgesForCorrectness($event->correctness);

        // For each of it increment the counter.
        Game::incrementManyBadges($event->user, $badges);
    }
}
