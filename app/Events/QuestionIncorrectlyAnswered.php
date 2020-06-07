<?php

namespace Gamify\Events;

use Gamify\Question;
use Gamify\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionIncorrectlyAnswered
{
    use Dispatchable, SerializesModels;

    /** @var \Gamify\User */
    public User $user;

    /** @var \Gamify\Question */
    public Question $question;

    /** @var int */
    public int $points;

    /**
     * Create a new event instance.
     *
     * @param \Gamify\User     $user
     * @param \Gamify\Question $question
     * @param int              $points
     *
     * @return void
     */
    public function __construct(User $user, Question $question, int $points)
    {
        $this->user = $user;
        $this->question = $question;
        $this->points = $points;
    }
}
