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

use Couchbase\Role;
use Gamify\Enums\Roles;
use Gamify\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserDataTablesControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function admins_should_get_data_tables_data(): void
    {
        $this->user->role = Roles::Admin;

        $users = User::factory()
            ->count(3)
            ->create();

        $this
            ->actingAs($this->user)
            ->ajaxGet(route('admin.users.data'))
            ->assertSuccessful()
            ->assertJsonCount(count($users) + 1, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'username',
                        'email',
                    ],
                ],
            ]);
    }

    /** @test */
    public function users_should_not_get_data_tables_data(): void
    {
        $this
            ->actingAs($this->user)
            ->ajaxGet(route('admin.users.data'))
            ->assertForbidden();
    }
}
