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

namespace Tests\Feature\Actions;

use Gamify\Actions\PublishQuestionAction;
use Gamify\Events\QuestionPublished;
use Gamify\Exceptions\QuestionPublishingException;
use Gamify\Models\Question;
use Gamify\Models\QuestionChoice;
use Illuminate\Support\Facades\Event;
use Tests\Feature\TestCase;

class PublishQuestionActionTest extends TestCase
{
    /** @test */
    public function it_triggers_an_event_when_a_question_is_published(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->has(QuestionChoice::factory()->correct(), 'choices')
            ->has(QuestionChoice::factory()->incorrect(), 'choices')
            ->create();

        Event::fake();

        $publisher = app()->make(PublishQuestionAction::class);

        $publisher->execute($question);

        Event::assertDispatched(QuestionPublished::class);

        $question->refresh();

        $this->assertEquals(Question::PUBLISH_STATUS, $question->status);
    }

    /** @test */
    public function it_does_not_trigger_an_event_when_a_question_was_already_published(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->published()
            ->create();

        Event::fake();

        $publisher = app()->make(PublishQuestionAction::class);

        $publisher->execute($question);

        Event::assertNotDispatched(QuestionPublished::class);

        $question->refresh();

        $this->assertEquals(Question::PUBLISH_STATUS, $question->status);
    }

    /** @test */
    public function it_throws_an_exception_when_trying_to_publish_a_question_without_at_least_two_choices(): void
    {
        $this->withoutExceptionHandling();

        /** @var Question $question */
        $question = Question::factory()
            ->has(QuestionChoice::factory(), 'choices')
            ->create();

        $this->expectException(QuestionPublishingException::class);

        $publisher = app()->make(PublishQuestionAction::class);

        $publisher->execute($question);
    }

    /** @test */
    public function it_throws_an_exception_when_trying_to_publish_a_question_without_a_correct_choice(): void
    {
        $this->withoutExceptionHandling();

        /** @var Question $question */
        $question = Question::factory()
            ->has(QuestionChoice::factory()->count(2)->incorrect(), 'choices')
            ->create();

        $this->expectException(QuestionPublishingException::class);

        $publisher = app()->make(PublishQuestionAction::class);

        $publisher->execute($question);
    }

    /** @test */
    public function it_publishes_question_when_date_is_on_the_past(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->has(QuestionChoice::factory()->correct(), 'choices')
            ->has(QuestionChoice::factory()->incorrect(), 'choices')
            ->create([
                'publication_date' => now()->subWeek(),
            ]);

        $publisher = app()->make(PublishQuestionAction::class);

        $publisher->execute($question);

        $this->assertEquals(Question::PUBLISH_STATUS, $question->status);
    }

    /** @test */
    public function it_schedules_question_publication_when_date_is_in_the_future(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->has(QuestionChoice::factory()->correct(), 'choices')
            ->has(QuestionChoice::factory()->incorrect(), 'choices')
            ->create([
                'publication_date' => now()->addWeek(),
            ]);

        $publisher = app()->make(PublishQuestionAction::class);

        $publisher->execute($question);

        $this->assertEquals(Question::FUTURE_STATUS, $question->status);
    }

    /** @test */
    public function it_does_not_trigger_an_event_when_publish_fails(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->has(QuestionChoice::factory(), 'choices')
            ->create();

        Event::fake();

        $publisher = app()->make(PublishQuestionAction::class);

        try {
            $publisher->execute($question);
        } catch (\Exception $exception) {
            // catch exception to make the test not fail by this reason
        }

        Event::assertNotDispatched(QuestionPublished::class);
    }
}
