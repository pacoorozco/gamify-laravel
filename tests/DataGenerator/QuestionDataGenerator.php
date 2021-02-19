<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Some rights reserved. See LICENSE and AUTHORS files.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

namespace Tests\DataGenerator;

use Gamify\Models\Question;

class QuestionDataGenerator
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
        /** @var Question $question */
        $question = Question::factory()->make();

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
