<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2019 by Paco Orozco <paco@pacoorozco.info>
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
 * @copyright          2019 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

namespace Tests\Feature;

use Gamify\User;
use Tests\TestCase;
use Gamify\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        \Artisan::call('db:seed');
    }

    public function testAdminRoleCanAccessToAdminDashboard()
    {
        $user = factory(User::class)->states('admin')->create();
        $profile = factory(UserProfile::class)->make();
        $user->profile()->save($profile);

        $response = $this->actingAs($user)
            ->get('/admin');

        $response->assertSuccessful();
    }

    public function testMemberRoleCanNotAccessToAdminDashboard()
    {
        $user = factory(User::class)->create();
        $profile = factory(UserProfile::class)->make();
        $user->profile()->save($profile);

        $response = $this->actingAs($user)
            ->get('/admin');

        $response->assertStatus(403);
    }
}
