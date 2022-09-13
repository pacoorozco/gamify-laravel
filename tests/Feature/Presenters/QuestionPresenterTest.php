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

namespace Tests\Feature\Presenters;

use Gamify\Models\Question;
use Gamify\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionPresenterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_return_not_available_when_the_creator_is_not_set(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->published()
            ->create();

        $this->assertEquals('N/A', $question->present()->creator());
    }

    /** @test */
    public function it_should_return_the_creator_of_a_question(): void
    {
        /** @var Question $question */
        $question = Question::factory()->make();
        $input_data = [
            'name' => $question->name,
            'question' => $question->question,
            'type' => $question->type,
            'hidden' => $question->hidden,
            'status' => $question->status,
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
        ];

        /** @var User $user */
        $user = User::factory()
            ->admin()
            ->create();

        $this
            ->actingAs($user)
            ->post(route('admin.questions.store'), $input_data)
            ->assertValid();

        /** @var Question $newQuestion */
        $newQuestion = Question::where([
            'name' => $question->name,
            'question' => $question->question,
            'type' => $question->type,
            'hidden' => $question->hidden,
            'status' => $question->status,
        ])->first();

        $this->assertEquals($user->username, $newQuestion->present()->creator());
    }

    /** @test */
    public function it_should_return_not_available_when_the_updater_is_not_set(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->published()
            ->create();

        $this->assertEquals('N/A', $question->present()->updater());
    }

    /** @test */
    public function it_should_return_the_updater_of_a_question(): void
    {
        /** @var Question $question */
        $question = Question::factory()->create([
            'name' => 'foo',
        ]);

        $input_data = [
            'name' => 'Bar',
            'question' => $question->question,
            'type' => $question->type,
            'hidden' => $question->hidden,
            'status' => $question->status,
        ];

        /** @var User $user */
        $user = User::factory()
            ->admin()
            ->create();

        $this
            ->actingAs($user)
            ->put(route('admin.questions.update', $question), $input_data)
            ->assertValid();

        $question->refresh();

        $this->assertEquals($user->username, $question->present()->updater());
    }
}
