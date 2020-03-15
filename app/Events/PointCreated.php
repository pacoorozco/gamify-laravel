<?php

namespace Gamify\Events;

use Gamify\Point;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PointCreated
{
    use Dispatchable, SerializesModels;

    /** @var \Gamify\User */
    public $user;

    /** @var int */
    public $points;

    /**
     * Create a new event instance.
     *
     * @param \Gamify\Point $point
     *
     * @return void
     */
    public function __construct(Point $point)
    {
        $this->user = $point->user()->first();
        $this->points = $point->points;
    }
}
