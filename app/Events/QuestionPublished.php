<?php

namespace Gamify\Events;

use Gamify\Question;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionPublished
{
    use Dispatchable, SerializesModels;

    /** @var \Gamify\Question */
    public $question;

    /**
     * Create a new event instance.
     *
     * @param \Gamify\Question $question
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
    }
}
