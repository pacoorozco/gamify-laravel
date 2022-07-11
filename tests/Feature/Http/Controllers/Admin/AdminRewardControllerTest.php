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

namespace Tests\Feature\Http\Controllers\Admin;

use Gamify\Enums\Roles;
use Gamify\Models\Badge;
use Gamify\Models\User;
use Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminRewardControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function players_should_not_see_the_index_view(): void
    {
        $this
            ->actingAs($this->user)
            ->get(route('admin.rewards.index'))
            ->assertForbidden();
    }

    /** @test */
    public function admins_should_see_the_index_view()
    {
        $this->user->role = Roles::Admin;

        $users = User::factory()
            ->count(2)
            ->create();

        $badges = Badge::factory()
            ->count(2)
            ->create();

        $this
            ->actingAs($this->user)
            ->get(route('admin.rewards.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.reward.index');
    }

    /** @test */
    public function players_should_not_reward_experience(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $want = [
            'points' => $this->faker->numberBetween(1, 10),
            'message' => $this->faker->sentence,
        ];

        $this
            ->actingAs($this->user)
            ->post(route('admin.rewards.experience'), [
                'username' => $user->username,
                'points' => $want['points'],
                'message' => $want['message'],
            ])
            ->assertForbidden();

        $user->refresh();

        $this->assertEquals(0, $user->experience);
    }

    /** @test */
    public function admins_should_reward_experience(): void
    {
        $this->user->role = Roles::Admin;

        /** @var User $user */
        $user = User::factory()->create();

        $want = [
            'points' => $this->faker->numberBetween(1, 10),
            'message' => $this->faker->sentence,
        ];

        $this
            ->actingAs($this->user)
            ->post(route('admin.rewards.experience'), [
                'username' => $user->username,
                'points' => $want['points'],
                'message' => $want['message'],
            ])
            ->assertRedirect(route('admin.rewards.index'));

        $user->refresh();

        $this->assertEquals($want['points'], $user->experience);
    }

    /**
     * @test
     * @dataProvider provideWrongDataForExperienceRewarding
     */
    public function admins_should_get_errors_when_rewarding_experience_with_wrong_data(
        array $data,
        array $errors,
    ): void
    {
        $this->user->role = Roles::Admin;

        /** @var User $user */
        $user = User::factory()->create([
            'username' => 'foo',
        ]);

        $formData = [
            'username' => $data['username'] ?? $user->username,
            'points' => $data['points'] ?? $this->faker->numberBetween(1, 10),
            'message' => $data['message'] ?? $this->faker->sentence,
        ];

        $this
            ->actingAs($this->user)
            ->post(route('admin.rewards.experience'), $formData)
            ->assertInvalid($errors);

        $user->refresh();

        $this->assertEquals(0, $user->experience);
    }

    public function provideWrongDataForExperienceRewarding(): Generator
    {
        yield 'username is empty' => [
            'data' => [
                'username' => '',
            ],
            'errors' => ['username'],
        ];

        yield 'username ! a user' => [
            'data' => [
                'username' => 'bar',
            ],
            'errors' => ['username'],
        ];

        yield 'points is empty' => [
            'data' => [
                'points' => '',
            ],
            'errors' => ['points'],
        ];

        yield 'points ! a number' => [
            'data' => [
                'points' => 'not-a-number',
            ],
            'errors' => ['points'],
        ];
    }

    /** @test */
    public function players_should_not_reward_badges(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create();

        $this
            ->actingAs($this->user)
            ->post(route('admin.rewards.badge'), [
                'badge_username' => $user->username,
                'badge' => $badge->id,
            ])
            ->assertForbidden();

        $user->refresh();

        $this->assertEquals(0, $user->badges()->count());
    }

    /** @test */
    public function admins_should_reward_badges(): void
    {
        $this->user->role = Roles::Admin;

        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create();

        $this
            ->actingAs($this->user)
            ->post(route('admin.rewards.badge'), [
                'badge_username' => $user->username,
                'badge' => $badge->id,
            ])
            ->assertRedirect(route('admin.rewards.index'));

        $user->refresh();

        $this->assertEquals(1, $user->badges()->count());
    }

    /**
     * @test
     * @dataProvider provideWrongDataForBadgeRewarding
     */
    public function admins_should_get_errors_when_rewarding_badges_with_wrong_data(
        array $data,
        array $errors,
    ): void {
        $this->user->role = Roles::Admin;

        /** @var User $user */
        $user = User::factory()->create([
            'username' => 'foo',
        ]);

        /** @var Badge $badge */
        $badge = Badge::factory()->create();

        $formData = [
            'badge_username' => $data['badge_username'] ?? $user->username,
            'badge' => $data['badge'] ?? $badge->id,
        ];

        $this
            ->actingAs($this->user)
            ->post(route('admin.rewards.badge'), $formData)
            ->dumpSession()
            ->assertInvalid($errors);

        $user->refresh();

        $this->assertEquals(0, $user->badges()->count());
    }

    public function provideWrongDataForBadgeRewarding(): Generator
    {
        yield 'badge_username is empty' => [
            'data' => [
                'badge_username' => '',
            ],
            'errors' => ['badge_username'],
        ];

        yield 'badge_username ! a user' => [
            'data' => [
                'badge_username' => 'bar',
            ],
            'errors' => ['badge_username'],
        ];

        yield 'badge is empty' => [
            'data' => [
                'badge' => '',
            ],
            'errors' => ['badge'],
        ];

        yield 'badge ! a badge' => [
            'data' => [
                'badge' => 'foo',
            ],
            'errors' => ['badge'],
        ];
    }
}
