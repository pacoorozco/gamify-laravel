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

namespace Tests\Feature\Actions;

use PHPUnit\Framework\Attributes\Test;
use Gamify\Actions\CreateUserAction;
use Gamify\Models\User;
use Gamify\Models\UserProfile;
use Tests\Feature\TestCase;

final class CreateUserTest extends TestCase
{
    #[Test]
    public function it_should_create_a_user_with_its_profile(): void
    {
        /** @var User $want */
        $want = User::factory()->make();

        $createUserAction = app()->make(CreateUserAction::class);

        $user = $createUserAction->execute(
            username: $want->username,
            email: $want->email,
            name: $want->name,
            password: $want->password,
            role: $want->role
        );

        $this->assertInstanceOf(User::class, $user);

        $this->assertInstanceOf(UserProfile::class, $user->profile);

        $this->assertModelExists($user);
    }
}
