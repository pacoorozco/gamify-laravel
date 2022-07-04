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

namespace Tests\Feature\Http\Controllers;

use Gamify\Events\QuestionAnswered;
use Gamify\Models\Question;
use Gamify\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class QuestionControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_should_show_the_questions_dashboard()
    {
        $this
            ->actingAs($this->user)
            ->get(route('questions.index'))
            ->assertSuccessful()
            ->assertViewIs('question.index')
            ->assertViewHasAll([
                'questions',
                'next_level_name',
                'points_to_next_level',
                'percentage_to_next_level',
                'answered_questions',
                'percentage_of_answered_questions',
            ]);
    }

    /** @test */
    public function it_should_response_not_found_when_question_is_not_published()
    {
        /** @var Question $question */
        $question = Question::factory()
            ->create();

        $this
            ->actingAs($this->user)
            ->get(route('questions.show', $question->short_name))
            ->assertNotFound();
    }

    /** @test */
    public function it_should_show_the_question_when_it_is_not_answered()
    {
        /** @var Question $question */
        $question = Question::factory()
            ->published()
            ->create();

        $this
            ->actingAs($this->user)
            ->get(route('questions.show', $question->short_name))
            ->assertSuccessful()
            ->assertViewIs('question.show')
            ->assertSeeText($question->name);
    }

    /** @test */
    public function answer_returns_proper_content()
    {
        /** @var Question $question */
        $question = Question::factory()
            ->published()
            ->create();

        $this
            ->actingAs($this->user)
            ->post(route('questions.answer', $question->short_name), [
                // Answer with the first available choice.
                'choices' => [$question->choices()->first()->id],
            ])
            ->assertSuccessful()
            ->assertViewIs('question.show-answered')
            ->assertViewHasAll([
                'response',
                'question',
            ]);
    }

    /** @test */
    public function it_fires_an_event_when_question_is_answered_correctly()
    {
        /** @var Question $question */
        $question = Question::factory()
            ->published()
            ->create();

        // Answer with the correct choice.
        $input_data = [
            'choices' => [$question->choices()->correct()->first()->id],
        ];

        Event::fake();

        $this->actingAs($this->user)
            ->post(route('questions.answer', $question->short_name), $input_data)
            ->assertOk();

        Event::assertDispatched(QuestionAnswered::class, function ($e) use ($question) {
            return $e->question->id === $question->id &&
                $e->correctness === true;
        });
    }

    /** @test */
    public function it_fires_an_event_when_question_is_answered_incorrectly()
    {
        /** @var Question $question */
        $question = Question::factory()
            ->published()
            ->create();

        // Answer with the incorrect choice.
        $input_data = [
            'choices' => [$question->choices()->incorrect()->first()->id],
        ];

        Event::fake();

        $this->actingAs($this->user)
            ->post(route('questions.answer', $question->short_name), $input_data)
            ->assertOk();

        Event::assertDispatched(QuestionAnswered::class, function ($e) use ($question) {
            return $e->question->id === $question->id &&
                $e->correctness === false;
        });
    }
}
