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
use Gamify\Models\Question;
use Gamify\Models\QuestionChoice;
use Gamify\Models\User;
use Gamify\Models\UserProfile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pendingQuestions_returns_a_collection()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->pendingQuestions());
    }

    /** @test */
    public function pendingQuestions_returns_specified_number_of_questions()
    {
        // Creates 5 published questions.
        /** @var User $admin */
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);
        Question::factory()
            ->count(5)
            ->has(QuestionChoice::factory()->correct(), 'choices')
            ->has(QuestionChoice::factory()->incorrect(), 'choices')
            ->create([
                'status' => Question::PUBLISH_STATUS,
                'publication_date' => now(),
            ]);

        /** @var User $user */
        $user = User::factory()->create();

        // We only want 3 of the 5 created questions.
        $this->assertCount(3, $user->pendingQuestions(3));
    }

    /** @test */
    public function pendingQuestions_returns_zero_when_no_questions()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertCount(0, $user->pendingQuestions());
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
}
