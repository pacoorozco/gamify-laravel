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

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Gamify\Enums\BadgeActuators;
use Gamify\Events\QuestionAnswered;
use Gamify\Listeners\AddBadgesOnQuestionAnswered;
use Gamify\Models\Badge;
use Gamify\Models\Question;
use Gamify\Models\User;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\Feature\TestCase;

final class AddBadgesOnQuestionAnsweredTest extends TestCase
{
    #[Test]
    public function it_should_listen_for_the_proper_event(): void
    {
        Event::fake();
        Event::assertListening(
            expectedEvent: QuestionAnswered::class,
            expectedListener: AddBadgesOnQuestionAnswered::class
        );
    }

    #[Test]
    #[DataProvider('provideTestCasesThatShouldTriggerABadge')]
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

        $listener = new AddBadgesOnQuestionAnswered();
        $listener->handle($event);

        $this->assertNotNull($user->progressToCompleteTheBadge($badge));
    }

    public static function provideTestCasesThatShouldTriggerABadge(): \Generator
    {
        yield 'OnQuestionAnswered & no tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionAnswered->value,
                'tags' => [],
            ],
            'questionAttributes' => [
                'tags' => [],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionAnswered & matching tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionAnswered->value,
                'tags' => ['tag', 'foo'],
            ],
            'questionAttributes' => [
                'tags' => ['tag', 'bar'],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionCorrectlyAnswered & no tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionCorrectlyAnswered->value,
                'tags' => [],
            ],
            'questionAttributes' => [
                'tags' => [],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionCorrectlyAnswered & matching tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionCorrectlyAnswered->value,
                'tags' => ['tag', 'foo'],
            ],
            'questionAttributes' => [
                'tags' => ['tag', 'bar'],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionIncorrectlyAnswered & no tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionIncorrectlyAnswered->value,
                'tags' => [],
            ],
            'questionAttributes' => [
                'tags' => [],
                'correctness' => false,
            ],
        ];

        yield 'OnQuestionIncorrectlyAnswered & matching tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionIncorrectlyAnswered->value,
                'tags' => ['tag', 'foo'],
            ],
            'questionAttributes' => [
                'tags' => ['tag', 'bar'],
                'correctness' => false,
            ],
        ];
    }

    #[Test]
    #[DataProvider('provideTestCasesThatShouldNotTriggerABadge')]
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

        $listener = new AddBadgesOnQuestionAnswered();
        $listener->handle($event);

        $this->assertNull($user->progressToCompleteTheBadge($badge));
    }

    public static function provideTestCasesThatShouldNotTriggerABadge(): \Generator
    {
        yield 'different actuator' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::None->value,
                'tags' => [],
            ],
            'questionAttributes' => [
                'tags' => [],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionAnswered & non matching tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionAnswered->value,
                'tags' => ['foo'],
            ],
            'questionAttributes' => [
                'tags' => ['bar'],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionAnswered & only question has tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionAnswered->value,
                'tags' => [],
            ],
            'questionAttributes' => [
                'tags' => ['bar'],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionAnswered & only badge has tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionAnswered->value,
                'tags' => ['foo'],
            ],
            'questionAttributes' => [
                'tags' => [],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionCorrectlyAnswered & answer is not correct' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionCorrectlyAnswered->value,
                'tags' => [],
            ],
            'questionAttributes' => [
                'tags' => [],
                'correctness' => false,
            ],
        ];

        yield 'OnQuestionCorrectlyAnswered & non matching tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionCorrectlyAnswered->value,
                'tags' => ['foo'],
            ],
            'questionAttributes' => [
                'tags' => ['bar'],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionIncorrectlyAnswered & answer is correct' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionIncorrectlyAnswered->value,
                'tags' => [],
            ],
            'questionAttributes' => [
                'tags' => [],
                'correctness' => true,
            ],
        ];

        yield 'OnQuestionIncorrectlyAnswered & non matching tags' => [
            'badgeAttributes' => [
                'actuators' => BadgeActuators::OnQuestionIncorrectlyAnswered->value,
                'tags' => ['foo'],
            ],
            'questionAttributes' => [
                'tags' => ['bar'],
                'correctness' => false,
            ],
        ];
    }
}
