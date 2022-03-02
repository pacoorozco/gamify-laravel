<?php

namespace Gamify\Console\Commands;

use Gamify\Models\Question;
use Illuminate\Console\Command;

class PublishScheduledQuestions extends Command
{
    protected $signature = 'gamify:publish';

    protected $description = 'Publish scheduled questions';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $questions = Question::scheduled()->orderBy('publication_date')->get();
        foreach ($questions as $question) {
            $question->publish();
        }

        return 0;
    }
}
