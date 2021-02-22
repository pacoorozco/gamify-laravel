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
use Gamify\Models\Level;
use Gamify\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLevelControllerTest extends TestCase
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
        $level = Level::factory()->create();
        $test_data = [
            ['protocol' => 'GET', 'route' => route('admin.levels.index')],
            ['protocol' => 'GET', 'route' => route('admin.levels.create')],
            ['protocol' => 'POST', 'route' => route('admin.levels.store')],
            ['protocol' => 'GET', 'route' => route('admin.levels.show', $level)],
            ['protocol' => 'GET', 'route' => route('admin.levels.edit', $level)],
            ['protocol' => 'PUT', 'route' => route('admin.levels.update', $level)],
            ['protocol' => 'GET', 'route' => route('admin.levels.delete', $level)],
            ['protocol' => 'DELETE', 'route' => route('admin.levels.destroy', $level)],
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
            ->get(route('admin.levels.data'))
            ->assertForbidden();
    }

    /** @test */
    public function index_returns_proper_content()
    {
        $this->get(route('admin.levels.index'))
            ->assertOK()
            ->assertViewIs('admin.level.index');
    }

    /** @test */
    public function create_returns_proper_content()
    {
        $this->get(route('admin.levels.create'))
            ->assertOk()
            ->assertViewIs('admin.level.create');
    }

    /** @test */
    public function store_creates_an_object()
    {
        /** @var Level $level */
        $level = Level::factory()->make();
        $input_data = [
            'name' => $level->name,
            'required_points' => $level->required_points,
            'active' => true,
        ];

        $this->post(route('admin.levels.store'), $input_data)
            ->assertRedirect(route('admin.levels.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function store_returns_errors_on_invalid_data()
    {
        $invalid_input_data = [];

        $this->post(route('admin.levels.store'), $invalid_input_data)
            ->assertSessionHasErrors()
            ->assertSessionHas('errors');
    }

    /** @test */
    public function show_returns_proper_content()
    {
        /** @var Level $level */
        $level = Level::factory()->create();

        $this->get(route('admin.levels.show', $level))
            ->assertOk()
            ->assertViewIs('admin.level.show')
            ->assertSee($level->name);
    }

    /** @test */
    public function edit_returns_proper_content()
    {
        /** @var Level $level */
        $level = Level::factory()->create();

        $this->get(route('admin.levels.edit', $level))
            ->assertOk()
            ->assertViewIs('admin.level.edit')
            ->assertSee($level->name);
    }

    /** @test */
    public function update_edits_an_object()
    {
        /** @var Level $level */
        $level = Level::factory()->create([
            'name' => 'Level gold',
        ]);
        $input_data = [
            'name' => 'Level silver',
            'required_points' => $level->required_points,
            'active' => true,
        ];

        $this->put(route('admin.levels.update', $level), $input_data)
            ->assertRedirect(route('admin.levels.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function update_returns_errors_on_invalid_data()
    {
        /** @var Level $level */
        $level = Level::factory()->create([
            'name' => 'Level gold',
        ]);
        $input_data = [
            'name' => '',
        ];

        $this->put(route('admin.levels.update', $level), $input_data)
            ->assertSessionHasErrors()
            ->assertSessionHas('errors');
    }

    /** @test */
    public function delete_returns_proper_content()
    {
        /** @var Level $level */
        $level = Level::factory()->create();

        $this->get(route('admin.levels.delete', $level))
            ->assertOk()
            ->assertViewIs('admin.level.delete')
            ->assertSee($level->name);
    }

    /** @test */
    public function destroy_deletes_an_object()
    {
        /** @var Level $level */
        $level = Level::factory()->create();

        $this->delete(route('admin.levels.destroy', $level))
            ->assertRedirect(route('admin.levels.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function data_returns_proper_content()
    {
        // One level has already been created: 'default' level.
        Level::factory()->count(2)->create();

        $this->withoutMiddleware(OnlyAjax::class)
            ->get(route('admin.levels.data'))
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function data_fails_for_non_ajax_calls()
    {
        // One level has already been created: 'default' level.
        Level::factory()->count(3)->create();

        $this->get(route('admin.levels.data'))
            ->assertForbidden();
    }
}
