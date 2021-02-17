<?php

namespace Gamify\Events;

use Gamify\Models\Question;
use Gamify\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionAnswered
{
    use Dispatchable, SerializesModels;

    /** @var \Gamify\Models\User */
    public User $user;

    /** @var \Gamify\Models\Question */
    public Question $question;

    /** @var int */
    public int $points;

    /** @var bool */
    public bool $correctness;

    /**
     * Create a new event instance.
     *
     * @param \Gamify\Models\User     $user
     * @param \Gamify\Models\Question $question
     * @param int              $points
     * @param bool             $correctness
     *
     * @return void
     */
    public function __construct(User $user, Question $question, int $points, bool $correctness)
    {
        $this->user = $user;
        $this->question = $question;
        $this->points = $points;
        $this->correctness = $correctness;
    }
}
