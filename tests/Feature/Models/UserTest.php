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

use Gamify\Models\Badge;
use Gamify\Models\Level;
use Gamify\Models\Question;
use Gamify\Models\User;
use Gamify\Models\UserProfile;
use Gamify\Models\UserResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_return_the_pending_questions_to_be_answered()
    {
        $questions = Question::factory()
            ->published()
            ->count(3)
            ->create();

        /** @var User $user */
        $user = User::factory()->create();

        $this->assertCount(count($questions), $user->pendingQuestions());
    }

    /** @test */
    public function it_should_return_a_portion_of_the_pending_questions_to_be_answered()
    {
        $questions = Question::factory()
            ->published()
            ->count(3)
            ->create();

        /** @var User $user */
        $user = User::factory()->create();

        $this->assertCount(2, $user->pendingQuestions(2));
    }

    /** @test */
    public function it_should_return_the_default_image_when_avatar_is_not_set(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertEquals(UserProfile::DEFAULT_IMAGE, $user->profile->avatarUrl);
    }

    /** @test */
    public function getCompletedBadges_returns_a_collection()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->getCompletedBadges());
    }

    /** @test */
    public function getCompletedBadges_returns_empty_collection_when_no_badges()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertCount(0, $user->getCompletedBadges());
    }

    /** @test */
    public function hasBadgeCompleted_returns_false_when_badge_is_not_completed()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create();

        $this->assertFalse($user->isBadgeUnlocked($badge));
    }

    /** @test */
    public function hasBadgeCompleted_returns_false_when_badge_is_completed()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create([
            'required_repetitions' => 1,
        ]);

        // Complete the badge
        $user->badges()->attach($badge->id, ['repetitions' => '1', 'unlocked_at' => now()]);

        $this->assertTrue($user->isBadgeUnlocked($badge));
    }

    /** @test */
    public function it_should_get_empty_string_when_birthdate_is_not_set()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $user->profile->date_of_birth = null;

        $this->assertEmpty($user->present()->birthdate);
    }

    /**
     * @test
     * @dataProvider providesPointsToNextLevelTestCases
     */
    public function it_should_return_points_to_the_next_level(
        int $experience,
        int $nextLevelExperience,
        int $want,
    ): void {
        /** @var User $user */
        $user = User::factory()->create();
        $user->experience = $experience;

        Level::factory()->create([
            'required_points' => $nextLevelExperience,
        ]);

        $this->assertEquals($want, $user->pointsToNextLevel());
    }

    public function providesPointsToNextLevelTestCases(): \Generator
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

    /**
     * @test
     * @dataProvider providesNextLevelCompletionTestCases
     */
    public function it_should_return_level_completion(
        int $experience,
        int $nextLevelExperience,
        int $want,
    ): void {
        /** @var User $user */
        $user = User::factory()->create();
        $user->experience = $experience;

        Level::factory()->create([
            'required_points' => $nextLevelExperience,
        ]);

        $this->assertEquals($want, $user->nextLevelCompletion());
    }

    public function providesNextLevelCompletionTestCases(): \Generator
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

    /** @test */
    public function it_should_return_the_user_response_of_a_question(): void
    {
        $question = Question::factory()
            ->published()
            ->create();

        $user = User::factory()
            ->create();

        $user->answeredQuestions()->attach($question, [
            'answers' => $question->choices->first(),
            'points' => 10,
        ]);

        $response = $user->getResponseForQuestion($question);

        $this->assertInstanceOf(UserResponse::class, $response);
    }
}
