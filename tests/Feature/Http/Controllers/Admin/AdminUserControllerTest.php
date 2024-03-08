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

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Gamify\Enums\Roles;
use Gamify\Models\User;
use Generator;
use Tests\Feature\TestCase;

final class AdminUserControllerTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::factory()->create();

        $this->user = $user;
    }

    #[Test]
    public function players_should_not_see_the_index_view(): void
    {
        $this
            ->actingAs($this->user)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    #[Test]
    public function admins_should_see_the_index_view(): void
    {
        $this->user->role = Roles::Admin();

        $this
            ->actingAs($this->user)
            ->get(route('admin.users.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.user.index');
    }

    #[Test]
    public function players_should_not_see_the_new_user_form(): void
    {
        $this
            ->actingAs($this->user)
            ->get(route('admin.users.create'))
            ->assertForbidden();
    }

    #[Test]
    public function admins_should_see_the_new_user_form(): void
    {
        $this->user->role = Roles::Admin();

        $this
            ->actingAs($this->user)
            ->get(route('admin.users.create'))
            ->assertSuccessful()
            ->assertViewIs('admin.user.create');
    }

    #[Test]
    public function players_should_not_create_users(): void
    {
        /** @var User $want */
        $want = User::factory()->make();

        $this
            ->actingAs($this->user)
            ->post(route('admin.users.store'), [
                'username' => $want->username,
                'name' => $want->name,
                'email' => $want->email,
                'role' => $want->role,
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing(User::class, [
            'username' => $want->username,
            'email' => $want->email,
        ]);
    }

    #[Test]
    public function admins_should_create_users(): void
    {
        $this->user->role = Roles::Admin();

        /** @var User $want */
        $want = User::factory()->make();

        $this
            ->actingAs($this->user)
            ->post(route('admin.users.store'), [
                'username' => $want->username,
                'name' => $want->name,
                'email' => $want->email,
                'role' => $want->role->value,
            ])
            ->assertRedirect(route('admin.users.index'))
            ->assertValid();

        $this->assertDatabaseHas(User::class, [
            'username' => $want->username,
            'name' => $want->name,
            'email' => $want->email,
            'role' => $want->role,
        ]);
    }

    #[Test]
    #[DataProvider('provideWrongDataForUserCreation')]
    public function admins_should_get_errors_when_creating_users_with_wrong_data(
        array $data,
        array $errors
    ): void {
        $this->user->role = Roles::Admin();

        // User to validate unique rules...
        User::factory()->create([
            'username' => 'john',
            'email' => 'john.doe@domain.local',
        ]);

        /** @var User $want */
        $want = User::factory()->make();

        $formData = [
            'username' => $data['username'] ?? $want->username,
            'name' => $data['name'] ?? $want->name,
            'email' => $data['email'] ?? $want->email,
            'role' => $data['role'] ?? $want->role->value,
        ];

        $this
            ->actingAs($this->user)
            ->post(route('admin.users.store'), $formData)
            ->assertInvalid($errors);

        $this->assertDatabaseMissing(User::class, [
            'username' => $formData['username'],
            'email' => $formData['email'],
        ]);
    }

    public static function provideWrongDataForUserCreation(): Generator
    {
        yield 'username is empty' => [
            'data' => [
                'username' => '',
            ],
            'errors' => ['username'],
        ];

        yield 'username > 255 chars' => [
            'data' => [
                'username' => '01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012
34567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345',
            ],
            'errors' => ['username'],
        ];

        yield 'username ! a username' => [
            'data' => [
                'username' => 'u$ern4me',
            ],
            'errors' => ['username'],
        ];

        yield 'username is taken' => [
            'data' => [
                'username' => 'john',
            ],
            'errors' => ['username'],
        ];

        yield 'name is empty' => [
            'data' => [
                'name' => '',
            ],
            'errors' => ['name'],
        ];

        yield 'email is empty' => [
            'data' => [
                'email' => '',
            ],
            'errors' => ['email'],
        ];

        yield 'email ! an email' => [
            'data' => [
                'email' => 'is-not-an-email',
            ],
            'errors' => ['email'],
        ];

        yield 'email is taken' => [
            'data' => [
                'email' => 'john.doe@domain.local',
            ],
            'errors' => ['email'],
        ];

        yield 'role ! a role' => [
            'data' => [
                'role' => 'non-existent-role',
            ],
            'errors' => ['role'],
        ];
    }

    #[Test]
    public function players_should_not_see_any_user(): void
    {
        $want = User::factory()->create();

        $this
            ->actingAs($this->user)
            ->get(route('admin.users.show', $want))
            ->assertForbidden();
    }

    #[Test]
    public function admins_should_see_any_user(): void
    {
        $this->user->role = Roles::Admin();

        $want = User::factory()->create();

        $this
            ->actingAs($this->user)
            ->get(route('admin.users.show', $want))
            ->assertSuccessful()
            ->assertViewIs('admin.user.show')
            ->assertViewHas('user', $want);
    }

    #[Test]
    public function players_should_not_see_the_edit_user_form(): void
    {
        $want = User::factory()->create();

        $this
            ->actingAs($this->user)
            ->get(route('admin.users.edit', $want))
            ->assertForbidden();
    }

    #[Test]
    public function admins_should_see_the_edit_user_form(): void
    {
        $this->user->role = Roles::Admin();

        $want = User::factory()->create();

        $this
            ->actingAs($this->user)
            ->get(route('admin.users.edit', $want))
            ->assertSuccessful()
            ->assertViewIs('admin.user.edit')
            ->assertViewHas('user', $want);
    }

    #[Test]
    public function players_should_not_update_users(): void
    {
        /** @var User $want */
        $want = User::factory()->create();

        $this
            ->actingAs($this->user)
            ->put(route('admin.users.update', $want), [])
            ->assertForbidden();

        $this->assertModelExists($want);
    }

    #[Test]
    public function admins_should_update_users(): void
    {
        $this->user->role = Roles::Admin();

        /** @var User $user */
        $user = User::factory()->create();

        /** @var User $want */
        $want = User::factory()->make();

        $this
            ->actingAs($this->user)
            ->put(route('admin.users.update', $user), [
                'name' => $want->name,
                'email' => $want->email,
                'role' => $want->role->value,
            ])
            ->assertRedirect(route('admin.users.edit', $user))
            ->assertValid();

        $this->assertDatabaseHas(User::class, [
            'id' => $user->id,
            'name' => $want->name,
            'email' => $want->email,
            'role' => $want->role,
        ]);
    }

    #[Test]
    public function admins_should_not_update_their_own_role(): void
    {
        $this->user->role = Roles::Admin();

        $this->user->save();

        /** @var User $want */
        $want = User::factory()->make();

        $this
            ->actingAs($this->user)
            ->put(route('admin.users.update', $this->user), [
                'name' => $want->name,
                'email' => $want->email,
                'role' => Roles::Player,
            ])
            ->assertRedirect(route('admin.users.edit', $this->user))
            ->assertValid();

        $this->assertDatabaseHas(User::class, [
            'username' => $this->user->username,
            'name' => $want->name,
            'email' => $want->email,
            'role' => $this->user->role,
        ]);
    }

    #[Test]
    #[DataProvider('provideWrongDataForUserModification')]
    public function admins_should_get_errors_when_updating_users_with_wrong_data(
        array $data,
        array $errors
    ): void {
        $this->user->role = Roles::Admin();

        // User to validate unique rules...
        User::factory()->create([
            'username' => 'john',
            'email' => 'john.doe@domain.local',
        ]);

        /** @var User $user */
        $user = User::factory()->create();

        $formData = [
            'name' => $data['name'] ?? $user->name,
            'email' => $data['email'] ?? $user->email,
            'role' => $data['role'] ?? $user->role->value,
        ];

        $this
            ->actingAs($this->user)
            ->put(route('admin.users.update', $user), $formData)
            ->assertInvalid($errors);

        $this->assertDatabaseHas(User::class, [
            'id' => $user->id,
            'username' => $user->username,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ]);
    }

    public static function provideWrongDataForUserModification(): Generator
    {
        yield 'name is empty' => [
            'data' => [
                'name' => '',
            ],
            'errors' => ['name'],
        ];

        yield 'email is empty' => [
            'data' => [
                'email' => '',
            ],
            'errors' => ['email'],
        ];

        yield 'email ! an email' => [
            'data' => [
                'email' => 'is-not-an-email',
            ],
            'errors' => ['email'],
        ];

        yield 'email is taken' => [
            'data' => [
                'email' => 'john.doe@domain.local',
            ],
            'errors' => ['email'],
        ];

        yield 'role ! a role' => [
            'data' => [
                'role' => 'non-existent-role',
            ],
            'errors' => ['role'],
        ];
    }

    #[Test]
    public function players_should_not_delete_users(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this
            ->actingAs($this->user)
            ->get(route('admin.users.destroy', $user))
            ->assertForbidden();
    }

    #[Test]
    public function admins_should_not_delete_themselves(): void
    {
        $this->user->role = Roles::Admin();

        $this
            ->actingAs($this->user)
            ->delete(route('admin.users.destroy', $this->user))
            ->assertForbidden();

        $this->assertModelExists($this->user);
    }

    #[Test]
    public function admins_should_delete_users(): void
    {
        $this->user->role = Roles::Admin();

        /** @var User $user */
        $user = User::factory()->create();

        $this
            ->actingAs($this->user)
            ->delete(route('admin.users.destroy', $user))
            ->assertRedirect(route('admin.users.index'));

        $this->assertModelMissing($user);
    }
}
