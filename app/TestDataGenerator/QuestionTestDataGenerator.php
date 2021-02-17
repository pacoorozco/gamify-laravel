<?php

namespace Gamify\TestDataGenerator;

use Gamify\Models\Question;

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

            // Tags
            'tags' => [
                'tag_1',
                'tag_2',
                'tag_3',
            ],

            // Choices
            'choices' => [
                [
                    'text' => 'option_0_is_correct',
                    'score' => '5',
                ],
                [
                    'text' => 'option_1_is_incorrect',
                    'score' => '-5',
                ],
            ],
        ], $overrides);
    }
}
