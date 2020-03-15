<?php

namespace Gamify\Listeners;

use Gamify\Events\QuestionAnswered;
use Gamify\Libs\Game\Game;

class AddReputation
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
        // Add XP to user
        Game::addReputation($event->user, $event->points, 'has earned '.$event->points.' points.');
    }
}
