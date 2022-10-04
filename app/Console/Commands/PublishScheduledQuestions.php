<?php

namespace Gamify\Console\Commands;

use Gamify\Actions\PublishQuestionAction;
use Gamify\Exceptions\QuestionPublishingException;
use Gamify\Models\Question;
use Illuminate\Console\Command;

class PublishScheduledQuestions extends Command
{
    protected $signature = 'gamify:publish';

    protected $description = 'Publish scheduled questions';

    public function handle(PublishQuestionAction $publisher): int
    {
        $questions = Question::scheduled()
            ->where('publication_date', '<', now())
            ->get();

        $published = 0;
        foreach ($questions as $question) {
            try {
                $publisher->execute($question);
                $published++;
            } catch (QuestionPublishingException $exception) {
                $this->error("Scheduled question '{$question->name}' can not be published, reason: {$exception->getMessage()}");
            }
        }

        ($published > 0)
            ? $this->info("{$published} of {$questions->count()} scheduled questions were sent to publication successfully!")
            : $this->info('No scheduled questions were ready for publication!');

        return ($questions->count() - $published > 0) ? self::FAILURE : self::SUCCESS;
    }
}
