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

namespace Tests\Feature\Jobs;

use Gamify\Exceptions\CannotCreateUser;
use Gamify\Jobs\CreateUser;
use Gamify\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_user_with_its_profile(): void
    {
        /** @var User $want */
        $want = User::factory()->make();

        $user = CreateUser::dispatchSync(
            $want->username,
            $want->email,
            $want->name,
            $want->password,
            $want->role,
        );

        $this->assertDatabaseHas(User::class, [
            'username' => $want->username,
            'email' => $want->email,
            'name' => $want->name,
            'role' => $want->role,
        ]);

        $this->assertNotNull($user->profile);
    }

    /** @test */
    public function it_raises_exception_when_email_address_is_not_unique(): void
    {
        /** @var User $conflictUser */
        $conflictUser = User::factory()->create();

        /** @var User $want */
        $want = User::factory()->make([
            'email' => $conflictUser->email,
        ]);

        $this->expectException(CannotCreateUser::class);

        $user = CreateUser::dispatchSync(
            $want->username,
            $want->email,
            $want->name,
            $want->password,
            $want->role,
        );

        $this->assertNull($user);
    }

    /** @test */
    public function it_raises_exception_when_username_is_not_unique(): void
    {
        /** @var User $conflictUser */
        $conflictUser = User::factory()->create();

        /** @var User $want */
        $want = User::factory()->make([
            'username' => $conflictUser->username,
        ]);

        $this->expectException(CannotCreateUser::class);

        $user = CreateUser::dispatchSync(
            $want->username,
            $want->email,
            $want->name,
            $want->password,
            $want->role,
        );

        $this->assertNull($user);
    }
}
