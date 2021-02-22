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

use Gamify\Enums\BadgeActuators;
use Gamify\Events\QuestionPublished;
use Gamify\Exceptions\QuestionPublishingException;
use Gamify\Models\Badge;
use Gamify\Models\Question;
use Gamify\Models\QuestionChoice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_scopePublished_returns_correct_data()
    {
        // three non-published Questions
        Question::factory()
            ->count(3)
            ->create([
                'status' => Question::DRAFT_STATUS,
            ]);

        // two published Questions
        Question::factory()
            ->count(2)
            ->create([
                'status' => Question::PUBLISH_STATUS,
            ]);

        $got = Question::published()->get();

        $this->assertCount(2, $got);
    }

    public function test_scopeVisible_returns_correct_data()
    {
        // this questions should not be shown
        Question::factory()
            ->count(3)
            ->create([
                'status' => Question::PUBLISH_STATUS,
                'hidden' => true,
            ]);

        // this questions should be shown
        Question::factory()
            ->count(2)
            ->create([
                'status' => Question::PUBLISH_STATUS,
                'hidden' => false,
            ]);

        $got = Question::visible()->get();

        $this->assertCount(2, $got);
    }

    public function test_getActionableBadgesForCorrectness_method()
    {
        /** @var Question $question */
        $question = Question::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create();

        $question->actions()->create([
            'when' => BadgeActuators::OnQuestionAnswered,
            'badge_id' => $badge->id,
        ]);

        $got = $question->getActionableBadgesForCorrectness(true);

        $this->assertInstanceOf(Collection::class, $got);
        $this->assertCount(1, $got);
    }

    /** @test */
    public function it_returns_true_when_question_can_be_published()
    {
        /** @var Question $question */
        $question = Question::factory()
            ->has(QuestionChoice::factory()->correct(), 'choices')
            ->has(QuestionChoice::factory()->incorrect(), 'choices')
            ->create();

        $this->assertTrue($question->canBePublished());
    }

    /** @test */
    public function it_returns_false_when_question_can_not_be_published()
    {
        /** @var Question $question */
        $question = Question::factory()->create();

        $this->assertFalse($question->canBePublished());
    }

    /** @test */
    public function it_triggers_an_event_when_a_question_is_published()
    {
        /** @var Question $question */
        $question = Question::factory()
            ->has(QuestionChoice::factory()->correct(), 'choices')
            ->has(QuestionChoice::factory()->incorrect(), 'choices')
            ->create();
        Event::fake(); // should be fake after question creation

        $question->publish();

        Event::assertDispatched(QuestionPublished::class);
    }

    /** @test */
    public function it_does_not_trigger_an_event_when_a_question_was_already_published()
    {
        $question = Question::factory()
            ->has(QuestionChoice::factory()->correct(), 'choices')
            ->has(QuestionChoice::factory()->incorrect(), 'choices')
            ->create([
                'status' => Question::PUBLISH_STATUS,
            ]);
        Event::fake(); // should be fake after question creation

        $question->publish();

        Event::assertNotDispatched(QuestionPublished::class);
    }

    /** @test */
    public function it_does_not_trigger_an_event_when_a_question_is_scheduled()
    {
        $question = Question::factory()
            ->has(QuestionChoice::factory()->correct(), 'choices')
            ->has(QuestionChoice::factory()->incorrect(), 'choices')
            ->create([
                'publication_date' => now()->addWeek(),
            ]);
        Event::fake(); // should be fake after question creation

        $question->publish();

        Event::assertNotDispatched(QuestionPublished::class);
    }

    /** @test */
    public function it_throws_an_exception_when_trying_to_publish_a_question_without_at_least_two_choices()
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
    public function it_throws_an_exception_when_trying_to_publish_a_question_without_a_correct_choice()
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
    public function it_publishes_question_when_date_is_on_the_past()
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
    public function it_schedules_question_publication_when_date_is_in_the_future()
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
    public function it_does_not_trigger_an_event_when_publish_fails()
    {
        /** @var Question $question */
        $question = Question::factory()
            ->has(QuestionChoice::factory(), 'choices')
            ->create();

        Event::fake(); // should be fake after question creation

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
    public function it_returns_formatted_publication_date_using_presenter()
    {
        /** @var Question $question */
        $question = Question::factory()
            ->create([
                'publication_date' => '2020-01-02 03:04:05',
            ]);

        $this->assertEquals('2020-01-02 03:04', $question->present()->publication_date);
    }

    /** @test */
    public function it_returns_empty_string_when_publication_date_is_not_set_using_presenter()
    {
        /** @var Question $question */
        $question = Question::factory()
            ->create([
                'publication_date' => null,
            ]);

        $this->assertEquals('', $question->present()->publication_date);
    }

    /** @test */
    public function it_returns_formatted_public_url_using_presenter()
    {
        /** @var Question $question */
        $question = Question::factory()
            ->create([
                'name' => 'test question number 1',
            ]);

        $this->assertEquals('http://localhost/questions/test-question-number-1', $question->present()->public_url);
    }
}
