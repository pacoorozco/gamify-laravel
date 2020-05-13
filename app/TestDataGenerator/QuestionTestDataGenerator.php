<?php

namespace Gamify\TestDataGenerator;

use Gamify\Question;

class QuestionTestDataGenerator
{
    /**
     * Generate sample form request data.
     *
     * @param array $overrides
     *
     * @return array
     */
    public static function FormRequestData(array $overrides = []): array
    {
        $question = factory(Question::class)->make();

        return array_merge([
            'name' => $question->name,
            'question' => $question->question,
            'type' => $question->type,
            'hidden' => $question->hidden,
            'status' => $question->status,

            // Choices
            'choice_text' => [
                'option_0_is_correct',
                'option_1_is_incorrect',
            ],
            'choice_score' => [
                '5',
                '-5',
            ]
        ], $overrides);
    }
}
