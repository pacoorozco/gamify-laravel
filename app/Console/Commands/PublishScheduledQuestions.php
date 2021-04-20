<?php

namespace Gamify\Console\Commands;

use Gamify\Models\Question;
use Illuminate\Console\Command;

class PublishScheduledQuestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gamify:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish scheduled questions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $questions = Question::scheduled()->orderBy('publication_date')->get();
        foreach ($questions as $question) {
            $question->publish();
        }
        return 0;
    }
}
