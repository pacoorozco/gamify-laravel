<?php

namespace Gamify\Events;

use Gamify\Question;
use Gamify\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionAnswered
{
    use Dispatchable, SerializesModels;

    /** @var \Gamify\User $user */
    public $user;

    /** @var \Gamify\Question $question */
    public $question;

    /** @var int $points */
    public $points;

    /** @var bool $answerCorrectness */
    public $answerCorrectness;

    /**
     * Create a new event instance.
     *
     * @param \Gamify\User     $user
     * @param \Gamify\Question $question
     * @param bool             $answerCorrectness
     * @param int              $points
     *
     * @return void
     */
    public function __construct(User $user, Question $question, bool $answerCorrectness, int $points)
    {
        $this->user = $user;
        $this->question = $question;
        $this->answerCorrectness = $answerCorrectness;
        $this->points = $points;
    }
}
