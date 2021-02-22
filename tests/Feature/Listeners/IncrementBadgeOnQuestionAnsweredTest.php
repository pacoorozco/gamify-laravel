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

namespace Tests\Feature\Listeners;

use Gamify\Enums\BadgeActuators;
use Gamify\Enums\QuestionActuators;
use Gamify\Events\QuestionAnswered;
use Gamify\Listeners\IncrementBadgesOnQuestionAnswered;
use Gamify\Models\Badge;
use Gamify\Models\Question;
use Gamify\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncrementBadgeOnQuestionAnsweredTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_increments_badges_with_OnQuestionAnswered_actuator()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create([
            'actuators' => BadgeActuators::OnQuestionAnswered,
        ]);

        /** @var Question $question */
        $question = Question::factory()->create();

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = true;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertEquals(1, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_does_not_increment_badges_without_OnQuestionAnswered_actuator()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create([
            'actuators' => BadgeActuators::None,
        ]);

        /** @var Question $question */
        $question = Question::factory()->create();

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = true;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertNull($user->badges()->wherePivot('badge_id', $badge->id)->first());
    }

    /** @test */
    public function it_increments_badges_with_OnQuestionCorrectlyAnswered_actuator_when_answer_is_correct()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create([
            'actuators' => BadgeActuators::OnQuestionCorrectlyAnswered,
        ]);

        /** @var Question $question */
        $question = Question::factory()->create();

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = true;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertEquals(1, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_increments_badges_with_OnQuestionIncorrectlyAnswered_actuator_when_answer_is_incorrect()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create([
            'actuators' => BadgeActuators::OnQuestionIncorrectlyAnswered,
        ]);

        /** @var Question $question */
        $question = Question::factory()->create();

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = false;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertEquals(1, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_does_not_increment_badges_with_OnQuestionCorrectlyAnswered_actuator_when_answer_is_incorrect()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create([
            'actuators' => BadgeActuators::OnQuestionCorrectlyAnswered,
        ]);

        /** @var Question $question */
        $question = Question::factory()->create();

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = false;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertNull($user->badges()->wherePivot('badge_id', $badge->id)->first());
    }

    /** @test */
    public function it_does_not_increment_badges_with_OnQuestionIncorrectlyAnswered_actuator_when_answer_is_correct()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create([
            'actuators' => BadgeActuators::OnQuestionIncorrectlyAnswered,
        ]);
        /** @var Question $question */
        $question = Question::factory()->create();

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = true;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertNull($user->badges()->wherePivot('badge_id', $badge->id)->first());
    }

    /** @test */
    public function it_increments_badges_with_OnQuestionIncorrectlyAnswered_actuator_associated_to_a_question_when_answer_is_incorrect(
    ) {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create();

        /** @var Question $question */
        $question = Question::factory()->create();
        $question->actions()->create([
            'when' => QuestionActuators::OnQuestionIncorrectlyAnswered,
            'badge_id' => $badge->id,
        ]);

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = false;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertEquals(1, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_increments_badges_with_OnQuestionIncorrectlyAnswered_actuator_associated_to_a_question_when_answer_is_correct(
    ) {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create();

        /** @var Question $question */
        $question = Question::factory()->create();
        $question->actions()->create([
            'when' => QuestionActuators::OnQuestionIncorrectlyAnswered,
            'badge_id' => $badge->id,
        ]);

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = true;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertNull($user->badges()->wherePivot('badge_id', $badge->id)->first());
    }
}
