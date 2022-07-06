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
use Tests\TestCase;

class AdminBadgeControllerTest extends TestCase
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
    public function players_should_not_see_the_index_view(): void
    {
        $this
            ->actingAs($this->user)
            ->get(route('admin.badges.index'))
            ->assertForbidden();
    }

    /** @test */
    public function admins_should_see_the_index_view()
    {
        $this->user->role = Roles::Admin;

        $this
            ->actingAs($this->user)
            ->get(route('admin.badges.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.badge.index');
    }

    /** @test */
    public function players_should_not_see_the_new_badge_form(): void
    {
        $this
            ->actingAs($this->user)
            ->get(route('admin.badges.create'))
            ->assertForbidden();
    }

    /** @test */
    public function admins_should_see_the_new_badge_form(): void
    {
        $this->user->role = Roles::Admin;

        $this
            ->actingAs($this->user)
            ->get(route('admin.badges.create'))
            ->assertSuccessful()
            ->assertViewIs('admin.badge.create');
    }

    /** @test */
    public function players_should_not_create_badges(): void
    {
        /** @var Badge $want */
        $want = Badge::factory()->make();

        $this
            ->actingAs($this->user)
            ->post(route('admin.badges.store'), [
                'name' => $want->name,
                'description' => $want->description,
                'required_repetitions' => $want->required_repetitions,
                'active' => $want->active,
                'actuators' => $want->actuators,
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing(Badge::class, [
            'name' => $want->name,
        ]);
    }

    /** @test */
    public function admins_should_create_badges(): void
    {
        $this->user->role = Roles::Admin;

        /** @var Badge $want */
        $want = Badge::factory()->make();

        $this
            ->actingAs($this->user)
            ->post(route('admin.badges.store'), [
                'name' => $want->name,
                'description' => $want->description,
                'required_repetitions' => $want->required_repetitions,
                'active' => $want->active,
                'actuators' => $want->actuators->value,
            ])
            ->assertRedirect(route('admin.badges.index'))
            ->assertValid();

        $this->assertDatabaseHas(Badge::class, [
            'name' => $want->name,
            'description' => $want->description,
            'required_repetitions' => $want->required_repetitions,
            'active' => $want->active,
            'actuators' => $want->actuators,
        ]);
    }

    /**
     * @test
     * @dataProvider provideWrongDataForBadgeCreation
     */
    public function admins_should_get_errors_when_creating_badges_with_wrong_data(
        array $data,
        array $errors
    ): void {
        $this->user->role = Roles::Admin;

        // Badge to validate unique rules...
        Badge::factory()->create([
            'name' => 'my badge',
        ]);

        /** @var Badge $want */
        $want = Badge::factory()->make();

        $formData = [
            'name' => $data['name'] ?? $want->name,
            'description' => $data['description'] ?? $want->description,
            'required_repetitions' => $data['required_repetitions'] ?? $want->required_repetitions,
            'active' => $data['active'] ?? $want->active,
            'actuators' => $data['actuators'] ?? $want->actuators->value,
        ];

        $this
            ->actingAs($this->user)
            ->post(route('admin.badges.store'), $formData)
            ->assertInvalid($errors);

        $this->assertDatabaseMissing(Badge::class, [
            'name' => $formData['name'],
            'description' => $formData['description'],
        ]);
    }

    public function provideWrongDataForBadgeCreation(): Generator
    {
        yield 'name is empty' => [
            'data' => [
                'name' => '',
            ],
            'errors' => ['name'],
        ];

        yield 'name is taken' => [
            'data' => [
                'name' => 'my badge',
            ],
            'errors' => ['name'],
        ];

        yield 'description is empty' => [
            'data' => [
                'description' => '',
            ],
            'errors' => ['description'],
        ];

        yield 'required_repetitions is empty' => [
            'data' => [
                'required_repetitions' => '',
            ],
            'errors' => ['required_repetitions'],
        ];

        yield 'required_repetitions ! an integer' => [
            'data' => [
                'required_repetitions' => 'foo',
            ],
            'errors' => ['required_repetitions'],
        ];

        yield 'required_repetitions ! valid' => [
            'data' => [
                'required_repetitions' => 0,
            ],
            'errors' => ['required_repetitions'],
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

        yield 'actuators is empty' => [
            'data' => [
                'actuators' => '',
            ],
            'errors' => ['actuators'],
        ];

        yield 'actuators ! valid' => [
            'data' => [
                'actuators' => 'foo',
            ],
            'errors' => ['actuators'],
        ];
    }

    /** @test */
    public function players_should_not_see_any_badge(): void
    {
        $want = Badge::factory()->create();

        $this
            ->actingAs($this->user)
            ->get(route('admin.badges.show', $want))
            ->assertForbidden();
    }

    /** @test */
    public function admins_should_see_any_badge(): void
    {
        $this->user->role = Roles::Admin;

        $badge = Badge::factory()->create();

        $this
            ->actingAs($this->user)
            ->get(route('admin.badges.show', $badge))
            ->assertSuccessful()
            ->assertViewIs('admin.badge.show')
            ->assertViewHas('badge', $badge);
    }

    /** @test */
    public function players_should_not_see_the_edit_badge_form(): void
    {
        $want = Badge::factory()->create();

        $this
            ->actingAs($this->user)
            ->get(route('admin.badges.edit', $want))
            ->assertForbidden();
    }

    /** @test */
    public function admins_should_see_the_edit_badge_form(): void
    {
        $this->user->role = Roles::Admin;

        $badge = Badge::factory()->create();

        $this
            ->actingAs($this->user)
            ->get(route('admin.badges.edit', $badge))
            ->assertSuccessful()
            ->assertViewIs('admin.badge.edit')
            ->assertViewHas('badge', $badge);
    }

    /** @test */
    public function players_should_not_update_badges(): void
    {
        $want = Badge::factory()->create();

        $this
            ->actingAs($this->user)
            ->put(route('admin.badges.update', $want), [])
            ->assertForbidden();

        $this->assertModelExists($want);
    }

    /** @test */
    public function admins_should_update_badges(): void
    {
        $this->user->role = Roles::Admin;

        /** @var Badge $badge */
        $badge = Badge::factory()->create();

        /** @var Badge $want */
        $want = Badge::factory()->make();

        $this
            ->actingAs($this->user)
            ->put(route('admin.badges.update', $badge), [
                'name' => $want->name,
                'description' => $want->description,
                'required_repetitions' => $want->required_repetitions,
                'active' => $want->active,
                'actuators' => $want->actuators->value,
            ])
            ->assertRedirect(route('admin.badges.index'))
            ->assertValid();

        $this->assertDatabaseHas(Badge::class, [
            'id' => $badge->id,
            'name' => $want->name,
            'description' => $want->description,
            'required_repetitions' => $want->required_repetitions,
            'active' => $want->active,
            'actuators' => $want->actuators->value,
        ]);
    }

    /**
     * @test
     * @dataProvider provideWrongDataForBadgeModification
     */
    public function admins_should_get_errors_when_updating_badges_with_wrong_data(
        array $data,
        array $errors
    ): void {
        $this->user->role = Roles::Admin;

        // Badge to validate unique rules...
        Badge::factory()->create([
            'name' => 'my badge',
        ]);

        /** @var Badge $level */
        $badge = Badge::factory()->create();

        /** @var Badge $want */
        $want = Badge::factory()->make();

        $formData = [
            'name' => $data['name'] ?? $want->name,
            'description' => $data['description'] ?? $want->description,
            'required_repetitions' => $data['required_repetitions'] ?? $want->required_repetitions,
            'active' => $data['active'] ?? $want->active,
            'actuators' => $data['actuators'] ?? $want->actuators->value,
        ];

        $this
            ->actingAs($this->user)
            ->put(route('admin.badges.update', $badge), $formData)
            ->assertInvalid($errors);

        $this->assertModelExists($badge);
    }

    public function provideWrongDataForBadgeModification(): Generator
    {
        yield 'name is empty' => [
            'data' => [
                'name' => '',
            ],
            'errors' => ['name'],
        ];

        yield 'name is taken' => [
            'data' => [
                'name' => 'my badge',
            ],
            'errors' => ['name'],
        ];

        yield 'description is empty' => [
            'data' => [
                'description' => '',
            ],
            'errors' => ['description'],
        ];

        yield 'required_repetitions is empty' => [
            'data' => [
                'required_repetitions' => '',
            ],
            'errors' => ['required_repetitions'],
        ];

        yield 'required_repetitions ! an integer' => [
            'data' => [
                'required_repetitions' => 'foo',
            ],
            'errors' => ['required_repetitions'],
        ];

        yield 'required_repetitions ! valid' => [
            'data' => [
                'required_repetitions' => 0,
            ],
            'errors' => ['required_repetitions'],
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

        yield 'actuators is empty' => [
            'data' => [
                'actuators' => '',
            ],
            'errors' => ['actuators'],
        ];

        yield 'actuators ! valid' => [
            'data' => [
                'actuators' => 'foo',
            ],
            'errors' => ['actuators'],
        ];
    }

    /** @test */
    public function players_should_not_delete_levels(): void
    {
        $badge = Badge::factory()->create();

        $this
            ->actingAs($this->user)
            ->delete(route('admin.badges.destroy', $badge))
            ->assertForbidden();
    }

    /** @test */
    public function admins_should_delete_badges(): void
    {
        $this->user->role = Roles::Admin;

        $badge = Badge::factory()->create();

        $this
            ->actingAs($this->user)
            ->delete(route('admin.badges.destroy', $badge))
            ->assertRedirect(route('admin.badges.index'));

        $this->assertSoftDeleted($badge);
    }
}
