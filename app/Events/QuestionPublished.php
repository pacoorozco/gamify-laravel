<?php

namespace Gamify\Events;

use Gamify\Models\Question;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionPublished
{
    use Dispatchable, SerializesModels;

    /** @var \Gamify\Models\Question */
    public $question;

    /**
     * Create a new event instance.
     *
     * @param \Gamify\Models\Question $question
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
    }
}
