<?php

namespace Gamify\Listeners;

use Gamify\Events\PointCreated;

class UpdateExperience
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
     * @param PointCreated $event
     *
     * @return void
     */
    public function handle(PointCreated $event)
    {
        $event->user->addExperience($event->points);
    }
}
