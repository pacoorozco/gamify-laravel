<?php

namespace Gamify\Events;

use Gamify\Models\Point;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PointCreated
{
    use Dispatchable, SerializesModels;

    /** @var \Gamify\Models\User */
    public $user;

    /** @var int */
    public $points;

    /**
     * Create a new event instance.
     *
     * @param \Gamify\Models\Point $point
     *
     * @return void
     */
    public function __construct(Point $point)
    {
        $this->user = $point->user()->first();
        $this->points = $point->points;
    }
}
