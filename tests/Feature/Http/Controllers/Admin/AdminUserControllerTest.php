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

use Gamify\Http\Middleware\OnlyAjax;
use Gamify\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        /** @var User $admin */
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);
    }

    /** @test */
    public function access_is_restricted_to_admins()
    {
        $user = User::factory()->create();
        $test_data = [
            ['protocol' => 'GET', 'route' => route('admin.users.index')],
            ['protocol' => 'GET', 'route' => route('admin.users.create')],
            ['protocol' => 'POST', 'route' => route('admin.users.store')],
            ['protocol' => 'GET', 'route' => route('admin.users.show', $user)],
            ['protocol' => 'GET', 'route' => route('admin.users.edit', $user)],
            ['protocol' => 'PUT', 'route' => route('admin.users.update', $user)],
            ['protocol' => 'GET', 'route' => route('admin.users.delete', $user)],
            ['protocol' => 'DELETE', 'route' => route('admin.users.destroy', $user)],
        ];

        /** @var User $user */
        $user = User::factory()->create();

        foreach ($test_data as $test) {
            $this->actingAs($user)
                ->call($test['protocol'], $test['route'])
                ->assertForbidden();
        }

        // Ajax routes needs to disable middleware
        $this->actingAs($user)
            ->withoutMiddleware(OnlyAjax::class)
            ->get(route('admin.users.data'))
            ->assertForbidden();
    }

    /** @test */
    public function index_returns_proper_content()
    {
        $this->get(route('admin.users.index'))
            ->assertOK()
            ->assertViewIs('admin.user.index');
    }

    /** @test */
    public function create_returns_proper_content()
    {
        $this->get(route('admin.users.create'))
            ->assertOk()
            ->assertViewIs('admin.user.create');
    }

    /** @test */
    public function store_creates_an_object()
    {
        /** @var User $user */
        $user = User::factory()->make();
        $input_data = [
            'username' => $user->username,
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'very_secret',
            'password_confirmation' => 'very_secret',
            'role' => $user->role,
        ];

        $this->post(route('admin.users.store'), $input_data)
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function store_returns_errors_on_invalid_data()
    {
        $invalid_input_data = [
            'username' => 'yoda',
        ];

        $this->post(route('admin.users.store'), $invalid_input_data)
            ->assertSessionHasErrors()
            ->assertSessionHas('errors');
    }

    /** @test */
    public function show_returns_proper_content()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->get(route('admin.users.show', $user))
            ->assertOk()
            ->assertViewIs('admin.user.show')
            ->assertSee($user->username);
    }

    /** @test */
    public function edit_returns_proper_content()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->get(route('admin.users.edit', $user))
            ->assertOk()
            ->assertViewIs('admin.user.edit')
            ->assertSee($user->name);
    }

    /** @test */
    public function update_edits_an_object()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'Han Solo',
        ]);
        $input_data = [
            'name' => 'Leia',
            'email' => $user->email,
            'role' => $user->role,
        ];

        $this->put(route('admin.users.update', $user), $input_data)
            ->assertRedirect(route('admin.users.edit', $user))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function update_does_not_allows_users_to_change_its_own_role()
    {
        /** @var User $user */
        $user = auth()->user();

        $input_data = [
            'name' => $user->username,
            'email' => $user->email,
            'role' => User::USER_ROLE,
        ];

        $this->put(route('admin.users.update', $user), $input_data)
            ->assertRedirect(route('admin.users.edit', $user))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');

        $this->assertTrue(User::findOrFail($user->id)->isAdmin());
    }

    /** @test */
    public function update_returns_errors_on_invalid_data()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'username' => 'anakin',
        ]);
        $input_data = [
            'username' => '',
        ];

        $this->put(route('admin.users.update', $user), $input_data)
            ->assertSessionHasErrors()
            ->assertSessionHas('errors');
    }

    /** @test */
    public function delete_returns_proper_content()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->get(route('admin.users.delete', $user))
            ->assertOk()
            ->assertViewIs('admin.user.delete')
            ->assertSee($user->name);
    }

    /** @test */
    public function destroy_deletes_an_object()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->delete(route('admin.users.destroy', $user))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function data_returns_proper_content()
    {
        // One user has already been created by setUp().
        User::factory()->count(3)->create();

        $this->withoutMiddleware(OnlyAjax::class)
            ->get(route('admin.users.data'))
            ->assertJsonCount(5, 'data');
    }

    /** @test */
    public function data_fails_for_non_ajax_calls()
    {
        // One user has already been created by setUp().
        User::factory()->count(3)->create();

        $this->get(route('admin.users.data'))
            ->assertForbidden();
    }
}
