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

namespace Tests\Feature\Http\Controllers;

use Gamify\Models\User;
use Tests\Feature\TestCase;

class ShowUserProfileControllerTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::factory()
            ->create();

        $this->user = $user;
    }

    /** @test */
    public function users_should_see_another_user_profiles_without_edit_buttons(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this
            ->actingAs($this->user)
            ->get(route('profiles.show', ['username' => $user->username]))
            ->assertSuccessful()
            ->assertViewIs('profile.show')
            ->assertViewHas('user', $user)
            ->assertDontSeeText(__('user/profile.edit_account'))
            ->assertDontSeeText(__('user/profile.change_password'));
    }

    /** @test */
    public function users_should_see_its_own_profile_edit_buttons(): void
    {
        $this
            ->actingAs($this->user)
            ->get(route('profiles.show', $this->user->username))
            ->assertSuccessful()
            ->assertViewIs('profile.show')
            ->assertViewHas('user', $this->user)
            ->assertSeeText(__('user/profile.edit_account'))
            ->assertSeeText(__('user/profile.change_password'));
    }
}
