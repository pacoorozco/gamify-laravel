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

namespace Tests\Feature\Models;

use Gamify\Models\Question;
use Gamify\Models\User;
use Gamify\Models\UserResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserResponseTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_should_return_the_user_response_score_of_a_question(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->published()
            ->create();

        /** @var User $user */
        $user = User::factory()
            ->create();

        $want = $this->faker->numberBetween(-10, 10);

        $user->answeredQuestions()->attach($question,
            UserResponse::asArray(
                score: $want,
                choices: $question->choices()->pluck('id')->toArray(),
            )
        );

        $response = $user->answeredQuestions()
            ->where('question_id', $question->id)
            ->first()
            ->response;

        $this->assertEquals($want, $response->score());
    }

    /** @test */
    public function it_should_return_the_user_response_choices_of_a_question(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->published()
            ->create();

        /** @var User $user */
        $user = User::factory()
            ->create();

        $choices = [1, 2];

        $user->answeredQuestions()->attach($question,
            UserResponse::asArray(
                score: $this->faker->numberBetween(-10, 10),
                choices: $choices,
            )
        );

        $response = $user->answeredQuestions()
            ->where('question_id', $question->id)
            ->first()
            ->response;

        $this->assertEquals($choices, $response->choices());
    }

    /** @test */
    public function it_should_return_if_a_choice_is_within_the_user_response_of_a_question(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->published()
            ->create();

        /** @var User $user */
        $user = User::factory()
            ->create();

        $choices = [2];

        $user->answeredQuestions()->attach($question,
            UserResponse::asArray(
                score: $this->faker->numberBetween(-10, 10),
                choices: $choices,
            )
        );

        $response = $user->answeredQuestions()
            ->where('question_id', $question->id)
            ->first()
            ->response;

        $this->assertFalse($response->hasChoice(1));

        $this->assertTrue($response->hasChoice(2));
    }
}
