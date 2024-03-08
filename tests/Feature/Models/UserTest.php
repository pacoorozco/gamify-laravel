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

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Gamify\Models\Badge;
use Gamify\Models\Level;
use Gamify\Models\Point;
use Gamify\Models\Question;
use Gamify\Models\User;
use Gamify\Models\UserBadgeProgress;
use Gamify\Models\UserResponse;
use Illuminate\Database\Eloquent\Collection;
use Tests\Feature\TestCase;

class UserTest extends TestCase
{
    #[Test]
    #[DataProvider('providesPendingVisibleQuestionsPaginationTestCases')]
    public function it_should_paginate_the_public_questions_pending_to_be_answered(
        int $questions_count,
        int $per_page_limit,
        int $expected,
    ): void {
        Question::factory()
            ->published()
            ->public()
            ->count($questions_count)
            ->create();

        // This question is always filtered due to the private visibility.
        Question::factory()
            ->published()
            ->private()
            ->create();

        /** @var User $user */
        $user = User::factory()->create();

        $this->assertCount($expected, $user->pendingQuestions($per_page_limit));
    }

    public static function providesPendingVisibleQuestionsPaginationTestCases(): \Generator
    {
        yield 'less questions than per-page limit' => [
            'questions_count' => 3,
            'per_page_limit' => 5,
            'expected' => 3,
        ];

        yield 'more questions than per-page limit' => [
            'questions_count' => 6,
            'per_page_limit' => 3,
            'expected' => 3,
        ];

        yield 'as many questions than per-page limit' => [
            'questions_count' => 3,
            'per_page_limit' => 3,
            'expected' => 3,
        ];
    }

    #[Test]
    public function it_should_return_the_default_image_when_avatar_is_not_set(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertEquals('/images/missing_profile.png', $user->profile->avatarUrl);
    }

    #[Test]
    public function getCompletedBadges_returns_a_collection(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->unlockedBadges());
    }

    #[Test]
    public function getCompletedBadges_returns_empty_collection_when_no_badges(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertCount(0, $user->unlockedBadges());
    }

    #[Test]
    public function hasBadgeCompleted_returns_false_when_badge_is_not_completed(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create();

        $this->assertFalse($user->hasUnlockedBadge($badge));
    }

    #[Test]
    public function hasBadgeCompleted_returns_false_when_badge_is_completed(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create([
            'required_repetitions' => 1,
        ]);

        // Complete the badge
        $user->badges()->attach($badge->id, ['repetitions' => '1', 'unlocked_at' => now()]);

        $this->assertTrue($user->hasUnlockedBadge($badge));
    }

    #[Test]
    public function it_should_get_empty_string_when_birthdate_is_not_set(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $user->profile->date_of_birth = null;

        $this->assertEmpty($user->present()->birthdate);
    }

    #[Test]
    #[DataProvider('providesPointsToNextLevelTestCases')]
    public function it_should_return_points_to_the_next_level(
        int $experience,
        int $nextLevelExperience,
        int $want,
    ): void {
        Level::factory()->create([
            'required_points' => $nextLevelExperience,
        ]);

        /** @var User $user */
        $user = User::factory()->create();
        Point::factory()
            ->for($user)
            ->create([
                'points' => $experience,
            ]);

        $this->assertEquals($want, $user->pointsToNextLevel());
    }

    public static function providesPointsToNextLevelTestCases(): \Generator
    {
        yield 'next level is above current experience' => [
            'experience' => 10,
            'nextLevelExperience' => 15,
            'want' => 5,
        ];

        yield 'next level is equal current experience' => [
            'experience' => 10,
            'nextLevelExperience' => 10,
            'want' => 0,
        ];

        yield 'next level is below current experience' => [
            'experience' => 15,
            'nextLevelExperience' => 10,
            'want' => 0,
        ];

        yield 'current experience is 0' => [
            'experience' => 0,
            'nextLevelExperience' => 10,
            'want' => 10,
        ];

        yield 'next level is the default level' => [
            'experience' => 10,
            'nextLevelExperience' => 0,
            'want' => 0,
        ];
    }

    #[Test]
    #[DataProvider('providesNextLevelCompletionTestCases')]
    public function it_should_return_level_completion(
        int $experience,
        int $nextLevelExperience,
        int $want,
    ): void {
        Level::factory()->create([
            'required_points' => $nextLevelExperience,
        ]);

        /** @var User $user */
        $user = User::factory()->create();
        Point::factory()
            ->for($user)
            ->create([
                'points' => $experience,
            ]);

        $this->assertEquals($want, $user->nextLevelCompletionPercentage());
    }

    public static function providesNextLevelCompletionTestCases(): \Generator
    {
        yield 'next level is above current experience' => [
            'experience' => 10,
            'nextLevelExperience' => 20,
            'want' => 50,
        ];

        yield 'next level is equal current experience' => [
            'experience' => 10,
            'nextLevelExperience' => 10,
            'want' => 100,
        ];

        yield 'next level is below current experience' => [
            'experience' => 15,
            'nextLevelExperience' => 10,
            'want' => 100,
        ];

        yield 'current experience is 0' => [
            'experience' => 0,
            'nextLevelExperience' => 10,
            'want' => 0,
        ];

        yield 'next level is the default level' => [
            'experience' => 10,
            'nextLevelExperience' => 0,
            'want' => 100,
        ];
    }

    #[Test]
    public function it_should_return_the_user_response_of_a_question(): void
    {
        /** @var Question $question */
        $question = Question::factory()
            ->published()
            ->create();

        /** @var User $user */
        $user = User::factory()
            ->create();

        $user->answeredQuestions()->attach($question, [
            'answers' => $question->choices->first(),
            'points' => 10,
        ]);

        $response = $user->getResponseForQuestion($question);

        $this->assertInstanceOf(UserResponse::class, $response);
    }

    #[Test]
    public function it_should_return_the_user_progress_for_a_badge(): void
    {
        /** @var Badge $badge */
        $badge = Badge::factory()
            ->create([
                'required_repetitions' => 5,
            ]);

        /** @var User $user */
        $user = User::factory()
            ->create();

        $user->badges()->attach($badge, [
            'repetitions' => 2,
        ]);

        $progress = $user->progressToCompleteTheBadge($badge);

        $this->assertInstanceOf(UserBadgeProgress::class, $progress);
    }
}
