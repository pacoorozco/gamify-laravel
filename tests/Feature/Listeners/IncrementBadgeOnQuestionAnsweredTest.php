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
use Gamify\Events\QuestionAnswered;
use Gamify\Listeners\IncrementBadgesOnQuestionAnswered;
use Gamify\Models\Badge;
use Gamify\Models\Question;
use Gamify\Models\User;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\Feature\TestCase;

class IncrementBadgeOnQuestionAnsweredTest extends TestCase
{
    /** @test */
    public function it_should_listen_for_the_event(): void
    {
        Event::fake();
        Event::assertListening(
            expectedEvent: QuestionAnswered::class,
            expectedListener: IncrementBadgesOnQuestionAnswered::class
        );
    }

    /**
     * @test
     * @dataProvider provideTestCasesThatShouldTriggerABadge
     */
    public function it_should_increment_badges_when_criteria_is_met(
        array $badgeAttributes,
        array $questionAttributes,
    ): void {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create([
            'actuators' => $badgeAttributes['actuators'],
        ]);
        $badge->tag($badgeAttributes['tags']);

        /** @var Question $question */
        $question = Question::factory()->create();
        $question->tag($questionAttributes['tags']);

        /** @var QuestionAnswered $event */
        $event = Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = $questionAttributes['correctness'];

        $listener = new IncrementBadgesOnQuestionAnswered();
        $listener->handle($event);

        $this->assertNotNull($user->progressToCompleteTheBadge($badge));
    }

    public static function provideTestCasesThatShouldTriggerABadge(): \Generator
    {
        yield 'OnQuestionAnswered & no tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionAnswered,
                'tags' => [],
            ],
            'questionAttributes' => [
                'tags' => [],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionAnswered & matching tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionAnswered,
                'tags' => ['tag', 'foo'],
            ],
            'questionAttributes' => [
                'tags' => ['tag', 'bar'],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionCorrectlyAnswered & no tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionCorrectlyAnswered,
                'tags' => [],
            ],
            'questionAttributes' => [
                'tags' => [],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionCorrectlyAnswered & matching tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionCorrectlyAnswered,
                'tags' => ['tag', 'foo'],
            ],
            'questionAttributes' => [
                'tags' => ['tag', 'bar'],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionIncorrectlyAnswered & no tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionIncorrectlyAnswered,
                'tags' => [],
            ],
            'questionAttributes' => [
                'tags' => [],
                'correctness' => false,
            ],
        ];

        yield 'OnQuestionIncorrectlyAnswered & matching tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionIncorrectlyAnswered,
                'tags' => ['tag', 'foo'],
            ],
            'questionAttributes' => [
                'tags' => ['tag', 'bar'],
                'correctness' => false,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider provideTestCasesThatShouldNotTriggerABadge
     */
    public function it_should_not_increment_badges_when_criteria_is_not_met(
        array $badgeAttributes,
        array $questionAttributes,
    ): void {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create([
            'actuators' => $badgeAttributes['actuators'],
        ]);
        $badge->tag($badgeAttributes['tags']);

        /** @var Question $question */
        $question = Question::factory()->create();
        $question->tag($questionAttributes['tags']);

        /** @var QuestionAnswered $event */
        $event = Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = $questionAttributes['correctness'];

        $listener = new IncrementBadgesOnQuestionAnswered();
        $listener->handle($event);

        $this->assertNull($user->progressToCompleteTheBadge($badge));
    }

    public static function provideTestCasesThatShouldNotTriggerABadge(): \Generator
    {
        yield 'different actuator' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::None,
                'tags' => [],
            ],
            'questionAttributes' => [
                'tags' => [],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionAnswered & non matching tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionAnswered,
                'tags' => ['foo'],
            ],
            'questionAttributes' => [
                'tags' => ['bar'],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionAnswered & only question has tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionAnswered,
                'tags' => [],
            ],
            'questionAttributes' => [
                'tags' => ['bar'],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionAnswered & only badge has tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionAnswered,
                'tags' => ['foo'],
            ],
            'questionAttributes' => [
                'tags' => [],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionCorrectlyAnswered & answer is not correct' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionCorrectlyAnswered,
                'tags' => [],
            ],
            'questionAttributes' => [
                'tags' => [],
                'correctness' => false,
            ],
        ];

        yield 'OnQuestionCorrectlyAnswered & non matching tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionCorrectlyAnswered,
                'tags' => ['foo'],
            ],
            'questionAttributes' => [
                'tags' => ['bar'],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionIncorrectlyAnswered & answer is correct' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionIncorrectlyAnswered,
                'tags' => [],
            ],
            'questionAttributes' => [
                'tags' => [],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionIncorrectlyAnswered & non matching tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionIncorrectlyAnswered,
                'tags' => ['foo'],
            ],
            'questionAttributes' => [
                'tags' => ['bar'],
                'correctness' => false,
            ],
        ];
    }
}
