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

namespace Tests\Feature\Http\Middleware;

use Gamify\Http\Middleware\RedirectIfAuthenticated;
use Gamify\Models\User;
use Gamify\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use Tests\Feature\TestCase;

class RedirectIfAuthenticatedTest extends TestCase
{
    const TEST_ENDPOINT = '/_test/only_for_guests';

    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware(RedirectIfAuthenticated::class)->get(self::TEST_ENDPOINT, function () {
            return 'Access granted for non authenticated users';
        });
    }

    /** @test */
    public function it_response_ok_for_non_authenticated_users(): void
    {
        $response = $this->get(self::TEST_ENDPOINT);

        $response->assertOk();
        $response->assertSee('Access granted for non authenticated users');
    }

    /** @test */
    public function it_redirects_to_home_for_authenticated_users_requests(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get(self::TEST_ENDPOINT);

        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
