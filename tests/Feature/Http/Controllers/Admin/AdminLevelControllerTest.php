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
use Gamify\Models\Level;
use Gamify\Models\User;
use Generator;
use Tests\Feature\TestCase;

class AdminLevelControllerTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        /** @var User user */
        $user = User::factory()->create();

        $this->user = $user;
    }

    /** @test */
    public function players_should_not_see_the_index_view(): void
    {
        $this
            ->actingAs($this->user)
            ->get(route('admin.levels.index'))
            ->assertForbidden();
    }

    /** @test */
    public function admins_should_see_the_index_view(): void
    {
        $this->user->role = Roles::Admin();

        $this
            ->actingAs($this->user)
            ->get(route('admin.levels.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.level.index');
    }

    /** @test */
    public function players_should_not_see_the_new_level_form(): void
    {
        $this
            ->actingAs($this->user)
            ->get(route('admin.levels.create'))
            ->assertForbidden();
    }

    /** @test */
    public function admins_should_see_the_new_level_form(): void
    {
        $this->user->role = Roles::Admin();

        $this
            ->actingAs($this->user)
            ->get(route('admin.levels.create'))
            ->assertSuccessful()
            ->assertViewIs('admin.level.create');
    }

    /** @test */
    public function players_should_not_create_levels(): void
    {
        /** @var Level $want */
        $want = Level::factory()->make();

        $this
            ->actingAs($this->user)
            ->post(route('admin.levels.store'), [
                'name' => $want->name,
                'required_points' => $want->required_points,
                'active' => $want->active,
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing(Level::class, [
            'name' => $want->name,
            'required_points' => $want->required_points,
        ]);
    }

    /** @test */
    public function admins_should_create_levels(): void
    {
        $this->user->role = Roles::Admin();

        /** @var Level $want */
        $want = Level::factory()->make();

        $this
            ->actingAs($this->user)
            ->post(route('admin.levels.store'), [
                'name' => $want->name,
                'required_points' => $want->required_points,
                'active' => $want->active,
            ])
            ->assertRedirect(route('admin.levels.index'))
            ->assertValid();

        $this->assertDatabaseHas(Level::class, [
            'name' => $want->name,
            'required_points' => $want->required_points,
            'active' => $want->active,
        ]);
    }

    /**
     * @test
     *
     * @dataProvider provideWrongDataForLevelCreation
     */
    public function admins_should_get_errors_when_creating_levels_with_wrong_data(
        array $data,
        array $errors
    ): void {
        $this->user->role = Roles::Admin();

        // Level to validate unique rules...
        Level::factory()->create([
            'name' => 'Level 42',
            'required_points' => 42,
        ]);

        /** @var Level $want */
        $want = Level::factory()->make();

        $formData = [
            'name' => $data['name'] ?? $want->name,
            'required_points' => $data['required_points'] ?? $want->required_points,
            'active' => $data['active'] ?? $want->active,
        ];

        $this
            ->actingAs($this->user)
            ->post(route('admin.levels.store'), $formData)
            ->assertInvalid($errors);

        $this->assertDatabaseMissing(Level::class, [
            'name' => $formData['name'],
            'required_points' => $formData['required_points'],
        ]);
    }

    public static function provideWrongDataForLevelCreation(): Generator
    {
        yield 'name is empty' => [
            'data' => [
                'name' => '',
            ],
            'errors' => ['name'],
        ];

        yield 'name is taken' => [
            'data' => [
                'name' => 'Level 42',
            ],
            'errors' => ['name'],
        ];

        yield 'required_points is empty' => [
            'data' => [
                'required_points' => '',
            ],
            'errors' => ['required_points'],
        ];

        yield 'required_points ! an integer' => [
            'data' => [
                'required_points' => 'foo',
            ],
            'errors' => ['required_points'],
        ];

        yield 'required_points is taken' => [
            'data' => [
                'required_points' => 42,
            ],
            'errors' => ['required_points'],
        ];

        yield 'active is empty' => [
            'data' => [
                'active' => '',
            ],
            'errors' => ['active'],
        ];

        yield 'active ! a boolean' => [
            'data' => [
                'active' => 'foo',
            ],
            'errors' => ['active'],
        ];
    }

    /** @test */
    public function players_should_not_see_any_level(): void
    {
        $want = Level::factory()->create();

        $this
            ->actingAs($this->user)
            ->get(route('admin.levels.show', $want))
            ->assertForbidden();
    }

    /** @test */
    public function admins_should_see_any_level(): void
    {
        $this->user->role = Roles::Admin();

        $level = Level::factory()->create();

        $this
            ->actingAs($this->user)
            ->get(route('admin.levels.show', $level))
            ->assertSuccessful()
            ->assertViewIs('admin.level.show')
            ->assertViewHas('level', $level);
    }

    /** @test */
    public function players_should_not_see_the_edit_level_form(): void
    {
        $want = Level::factory()->create();

        $this
            ->actingAs($this->user)
            ->get(route('admin.levels.edit', $want))
            ->assertForbidden();
    }

    /** @test */
    public function admins_should_see_the_edit_level_form(): void
    {
        $this->user->role = Roles::Admin();

        $level = Level::factory()->create();

        $this
            ->actingAs($this->user)
            ->get(route('admin.levels.edit', $level))
            ->assertSuccessful()
            ->assertViewIs('admin.level.edit')
            ->assertViewHas('level', $level);
    }

    /** @test */
    public function players_should_not_update_levels(): void
    {
        /** @var Level $want */
        $want = Level::factory()->create();

        $this
            ->actingAs($this->user)
            ->put(route('admin.levels.update', $want), [])
            ->assertForbidden();

        $this->assertModelExists($want);
    }

    /** @test */
    public function admins_should_update_levels(): void
    {
        $this->user->role = Roles::Admin();

        /** @var Level $level */
        $level = Level::factory()->create();

        /** @var Level $want */
        $want = Level::factory()->make();

        $this
            ->actingAs($this->user)
            ->put(route('admin.levels.update', $level), [
                'name' => $want->name,
                'required_points' => $want->required_points,
                'active' => $want->active,
            ])
            ->assertRedirect(route('admin.levels.index'))
            ->assertValid();

        $this->assertDatabaseHas(Level::class, [
            'id' => $level->id,
            'name' => $want->name,
            'required_points' => $want->required_points,
            'active' => $want->active,
        ]);
    }

    /**
     * @test
     *
     * @dataProvider provideWrongDataForLevelModification
     */
    public function admins_should_get_errors_when_updating_levels_with_wrong_data(
        array $data,
        array $errors
    ): void {
        $this->user->role = Roles::Admin();

        // Level to validate unique rules...
        Level::factory()->create([
            'name' => 'Level 42',
            'required_points' => 42,
        ]);

        /** @var Level $level */
        $level = Level::factory()->create();

        /** @var Level $want */
        $want = Level::factory()->make();

        $formData = [
            'name' => $data['name'] ?? $want->name,
            'required_points' => $data['required_points'] ?? $want->required_points,
            'active' => $data['active'] ?? $want->active,
        ];

        $this
            ->actingAs($this->user)
            ->put(route('admin.levels.update', $level), $formData)
            ->assertInvalid($errors);

        $this->assertModelExists($level);
    }

    public static function provideWrongDataForLevelModification(): Generator
    {
        yield 'name is empty' => [
            'data' => [
                'name' => '',
            ],
            'errors' => ['name'],
        ];

        yield 'name is taken' => [
            'data' => [
                'name' => 'Level 42',
            ],
            'errors' => ['name'],
        ];

        yield 'required_points is empty' => [
            'data' => [
                'required_points' => '',
            ],
            'errors' => ['required_points'],
        ];

        yield 'required_points ! an integer' => [
            'data' => [
                'required_points' => 'foo',
            ],
            'errors' => ['required_points'],
        ];

        yield 'required_points is taken' => [
            'data' => [
                'required_points' => 42,
            ],
            'errors' => ['required_points'],
        ];

        yield 'active is empty' => [
            'data' => [
                'active' => '',
            ],
            'errors' => ['active'],
        ];

        yield 'active ! a boolean' => [
            'data' => [
                'active' => 'foo',
            ],
            'errors' => ['active'],
        ];
    }

    /** @test */
    public function players_should_not_delete_levels(): void
    {
        $level = Level::factory()->create();

        $this
            ->actingAs($this->user)
            ->delete(route('admin.levels.destroy', $level))
            ->assertForbidden();
    }

    /** @test */
    public function admins_should_delete_levels(): void
    {
        $this->user->role = Roles::Admin();

        $level = Level::factory()->create();

        $this
            ->actingAs($this->user)
            ->delete(route('admin.levels.destroy', $level))
            ->assertRedirect(route('admin.levels.index'));

        $this->assertSoftDeleted($level);
    }
}
