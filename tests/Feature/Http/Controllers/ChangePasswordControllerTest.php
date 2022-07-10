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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChangePasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    const VALID_PASSWORD = 'foo#B4rBaz';

    /** @test */
    public function it_shows_password_change_form_for_logged_users()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('account.password.index'))
            ->assertSuccessful()
            ->assertViewIs('account.password.index');
    }

    /** @test */
    public function it_shows_error_for_non_logged_users()
    {
        $this
            ->get(route('account.password.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function it_shows_validation_error_if_current_password_is_invalid()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'password' => 'this-is-the-password',
        ]);

        $this
            ->actingAs($user)
            ->post(route('account.password.update'), [
                'current-password' => 'this-is-not-the-password',
                'new-password' => self::VALID_PASSWORD,
                'new-password_confirmation' => self::VALID_PASSWORD,
            ])
            ->assertInvalid(['current-password']);
    }

    /** @test */
    public function it_shows_validation_error_if_new_password_confirmation_does_not_match()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'password' => 'this-is-the-password',
        ]);

        $this
            ->actingAs($user)
            ->post(route('account.password.update'), [
                'current-password' => 'this-is-the-password',
                'new-password' => 'foo#B4rBaz',
                'new-password_confirmation' => 'anotherFoo',
            ])
            ->assertInvalid(['new-password']);
    }

    /** @test */
    public function it_has_success_key_on_session_when_password_has_been_changed()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'password' => 'this-is-the-password',
        ]);

        $want = self::VALID_PASSWORD;

        $this
            ->actingAs($user)
            ->post(route('account.password.update'), [
                'current-password' => 'this-is-the-password',
                'new-password' => $want,
                'new-password_confirmation' => $want,
            ])
            ->assertRedirect(route('account.password.index'))
            ->assertValid()
            ->assertSessionHas('success');

        Hash::check($want, $user->password);
    }
}
