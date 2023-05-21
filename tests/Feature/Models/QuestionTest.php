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

use Gamify\Events\QuestionPublished;
use Gamify\Exceptions\QuestionPublishingException;
use Gamify\Models\Question;
use Gamify\Models\QuestionChoice;
use Illuminate\Support\Facades\Event;
use Tests\Feature\TestCase;

class QuestionTest extends TestCase
{
    /** @test */
    public function it_should_return_only_published_questions(): void
    {
        Question::factory()
            ->create();

        Question::factory()
            ->scheduled()
            ->create();

        // these questions should be shown
        $want = Question::factory()
            ->published()
            ->count(2)
            ->create();

        $questions = Question::query()
            ->published()
            ->get();

        $this->assertCount($want->count(), $questions);

        $this->assertEquals(
            $want->pluck(['id']),
            $questions->pluck(['id'])
        );
    }

    /** @test */
    public function it_should_return_only_public_published_questions(): void
    {
        Question::factory()
            ->private()
            ->create();

        Question::factory()
            ->scheduled()
            ->private()
            ->create();

        // these questions should be shown
        $want = Question::factory()
            ->public()
            ->count(2)
            ->create();

        $questions = Question::query()
            ->public()
            ->get();

        $this->assertCount($want->count(), $questions);

        $this->assertEquals(
            $want->pluck(['id']),
            $questions->pluck(['id'])
        );
    }

    /** @test */
    public function it_should_collect_only_scheduled_questions(): void
    {
        Question::factory()
            ->create();

        Question::factory()
            ->published()
            ->create();

        // these questions should be shown
        $want = Question::factory()
            ->scheduled()
            ->count(2)
            ->create();

        $questions = Question::query()
            ->scheduled()
            ->get();

        $this->assertCount($want->count(), $questions);

        $this->assertEquals(
            $want->pluck(['id']),
            $questions->pluck(['id'])
        );
    }

    /** @test */
    public function it_should_return_true_if_question_can_be_published(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->has(QuestionChoice::factory()->correct(), 'choices')
            ->has(QuestionChoice::factory()->incorrect(), 'choices')
            ->create();

        $this->assertTrue($question->canBePublished());
    }

    /** @test */
    public function it_should_return_false_if_question_can_not_be_published(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->has(QuestionChoice::factory(), 'choices')
            ->create();

        $this->assertFalse($question->canBePublished());
    }

    /** @test */
    public function it_triggers_an_event_when_a_question_is_published(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->has(QuestionChoice::factory()->correct(), 'choices')
            ->has(QuestionChoice::factory()->incorrect(), 'choices')
            ->create();

        Event::fake();

        $question->publish();

        Event::assertDispatched(QuestionPublished::class);
    }

    /** @test */
    public function it_does_not_trigger_an_event_when_a_question_was_already_published(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->published()
            ->create();

        Event::fake();

        $question->publish();

        Event::assertNotDispatched(QuestionPublished::class);
    }

    /** @test */
    public function it_does_not_trigger_an_event_when_a_question_is_scheduled(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->has(QuestionChoice::factory()->correct(), 'choices')
            ->has(QuestionChoice::factory()->incorrect(), 'choices')
            ->create([
                'publication_date' => now()->addWeek(),
            ]);

        Event::fake();

        $question->publish();

        Event::assertNotDispatched(QuestionPublished::class);
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

        $question->publish();
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

        $question->publish();
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

        $question->publish();

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

        $question->publish();

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

        try {
            $question->publish();
        } catch (\Exception $exception) {
            // catch exception to make the test not fail by this reason
        }

        Event::assertNotDispatched(QuestionPublished::class);
    }

    /**
     * PRESENTERS.
     *
     * @see \Gamify\Presenters\QuestionPresenter
     */

    /** @test */
    public function it_returns_formatted_publication_date_using_presenter(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->create([
                'publication_date' => '2020-01-02 03:04:05',
            ]);

        $this->assertEquals('2020-01-02 03:04', $question->present()->publicationDate);
    }

    /** @test */
    public function it_returns_empty_string_when_publication_date_is_not_set_using_presenter(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->create([
                'publication_date' => null,
            ]);

        $this->assertEquals('', $question->present()->publicationDate);
    }
}
