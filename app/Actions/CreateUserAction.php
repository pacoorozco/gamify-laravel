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

namespace Gamify\Actions;

use Gamify\Models\User;
use Illuminate\Auth\Events\Registered;

final class CreateUserAction
{
    /**
     * Creates an User, its profile and dispatch events.
     *
     * @param  string  $username
     * @param  string  $email
     * @param  string  $name
     * @param  string  $password
     * @param  string  $role
     * @param  bool  $skipEmailVerification
     * @return \Gamify\Models\User
     */
    public function execute(
        string $username,
        string $email,
        string $name,
        string $password,
        string $role,
        bool $skipEmailVerification = false
    ): User {
        $user = User::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        ]);

        $user->profile()->create();

        if ($skipEmailVerification) {
            $user->email_verified_at = now();
            $user->save();
        }

        event(new Registered($user));

        return $user;
    }
}
