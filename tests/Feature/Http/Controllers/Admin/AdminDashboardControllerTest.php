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

use PHPUnit\Framework\Attributes\Test;
use Gamify\Models\User;
use Tests\Feature\TestCase;

class AdminDashboardControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $admin */
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);
    }

    #[Test]
    public function access_is_restricted_to_admins(): void
    {
        $test_data = [
            ['protocol' => 'GET', 'route' => route('admin.home')],
        ];

        /** @var User $user */
        $user = User::factory()->create();

        foreach ($test_data as $test) {
            $this->actingAs($user)
                ->call($test['protocol'], $test['route'])
                ->assertForbidden();
        }
    }

    #[Test]
    public function index_returns_proper_content(): void
    {
        $this->get(route('admin.home'))
            ->assertOK()
            ->assertViewIs('admin.dashboard.index')
            ->assertViewHasAll([
                'players_count',
                'questions_count',
                'badges_count',
                'levels_count',
                'latest_questions',
                'latest_users',
            ]);
    }
}
