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

namespace Tests\Feature\Http\Controllers\Account;

use Gamify\Events\UserProfileUpdated;
use Gamify\Models\User;
use Gamify\Models\UserProfile;
use Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()
            ->create();
    }

    /** @test */
    public function users_should_update_its_own_profile(): void
    {
        /** @var UserProfile $want */
        $want = UserProfile::factory()->make();

        $this
            ->actingAs($this->user)
            ->put(route('account.profile.update', $this->user->username), [
                'bio' => $want->bio,
                'date_of_birth' => $want->date_of_birth,
                'twitter' => $want->twitter,
                'facebook' => $want->facebook,
                'linkedin' => $want->linkedin,
                'github' => $want->github,
            ])
            ->assertRedirect(route('account.index'))
            ->assertValid();

        $this->assertDatabaseHas(UserProfile::class, [
            'user_id' => $this->user->id,
            'bio' => $want->bio,
            'date_of_birth' => $want->date_of_birth,
            'twitter' => $want->twitter,
            'facebook' => $want->facebook,
            'linkedin' => $want->linkedin,
            'github' => $want->github,
        ]);
    }

    /**
     * @test
     * @dataProvider provideWrongDataForUserProfileModification
     */
    public function users_should_get_errors_when_updating_its_own_profile_with_wrong_data(
        array $data,
        array $errors
    ): void {
        $userProfile = $this->user->profile;

        /** @var UserProfile $want */
        $want = UserProfile::factory()->make();

        $formData = [
            'bio' => $data['bio'] ?? $want->bio,
            'date_of_birth' => $data['date_of_birth'] ?? $want->date_of_birth,
            'twitter' => $data['twitter'] ?? $want->twitter,
            'facebook' => $data['facebook'] ?? $want->facebook,
            'linkedin' => $data['linkedin'] ?? $want->linkedin,
            'github' => $data['github'] ?? $want->github,
        ];

        $this
            ->actingAs($this->user)
            ->put(route('account.profile.update', $this->user->username), $formData)
            ->assertInvalid($errors);

        $this->assertModelExists($userProfile);
    }

    public function provideWrongDataForUserProfileModification(): Generator
    {
        yield 'birthdate ! a date' => [
            'data' => [
                'date_of_birth' => 'foo',
            ],
            'errors' => ['date_of_birth'],
        ];
    }

    /** @test */
    public function users_should_update_its_own_avatar(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $this
            ->actingAs($this->user)
            ->put(route('account.profile.update', $this->user->username), [
                'image' => $file,
            ])
            ->assertRedirect(route('account.index'))
            ->assertValid();

        Storage::disk('public')->assertExists('avatars/' . $file->hashName());

        $this->assertEquals(Storage::url('avatars/' . $file->hashName()), $this->user->profile->avatarUrl);
    }

    /** @test */
    public function event_should_be_dispatched_when_user_profile_is_updating_at_least_one_attribute(): void
    {
        Event::fake([
            UserProfileUpdated::class,
        ]);

        $this
            ->actingAs($this->user)
            ->put(route('account.profile.update', $this->user->username), [
                'bio' => 'foo',
            ])
            ->assertRedirect(route('account.index'))
            ->assertValid();

        Event::assertDispatched(UserProfileUpdated::class);
    }

    /** @test */
    public function event_should_not_be_dispatched_when_user_profile_is_not_updating_any_attribute(): void
    {
        Event::fake([
            UserProfileUpdated::class,
        ]);

        $this
            ->actingAs($this->user)
            ->put(route('account.profile.update', $this->user->username), [])
            ->assertRedirect(route('account.index'))
            ->assertValid();

        Event::assertNotDispatched(UserProfileUpdated::class);
    }
}