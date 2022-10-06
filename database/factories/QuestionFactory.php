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

namespace Database\Factories;

use Gamify\Models\Question;
use Gamify\Models\QuestionChoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function configure(): self
    {
        /** @phpstan-ignore-next-line */
        return $this->afterCreating(function (Question $question) {
            if ($question->isPublished() || $question->isScheduled()) {
                QuestionChoice::factory()
                    ->for($question)
                    ->count(2)
                    ->state(new Sequence(
                        ['score' => $this->faker->numberBetween(1, 5)],
                        ['score' => $this->faker->numberBetween(-5, -1)],
                    ))
                    ->create();
            }
        });
    }

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'question' => $this->faker->paragraph,
            'solution' => $this->faker->paragraph,
            'type' => Question::SINGLE_RESPONSE_TYPE,
            'hidden' => $this->faker->boolean,
            'status' => Question::DRAFT_STATUS,
        ];
    }

    public function published(): Factory
    {
        return $this->state(function () {
            return [
                'status' => Question::PUBLISH_STATUS,
                'publication_date' => now()->subWeek(),
            ];
        });
    }

    public function scheduled(): Factory
    {
        return $this->state(function () {
            return [
                'status' => Question::FUTURE_STATUS,
                'publication_date' => now()->addWeek(),
            ];
        });
    }

    public function public(): Factory
    {
        return $this->state(function () {
            return [
                'hidden' => false,
            ];
        });
    }

    public function private(): Factory
    {
        return $this->state(function () {
            return [
                'hidden' => true,
            ];
        });
    }
}
