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

namespace Gamify\Jobs;

use Gamify\Exceptions\CannotCreateUser;
use Gamify\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\Dispatchable;

final class CreateUser
{
    use Dispatchable;

    public function __construct(
        private string $username,
        private string $email,
        private string $name,
        private string $password,
        private string $role
    ) {
    }

    /**
     * @throws \Gamify\Exceptions\CannotCreateUser
     */
    public function handle(): User
    {

        $this->assertEmailAddressIsUnique($this->email);
        $this->assertUsernameIsUnique($this->username);

        $user = new User([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => $this->role,
        ]);

        try {
            $user->saveOrFail();

            $user->profile()->create([
                'avatar' => asset('images/missing_profile.png'),
            ]);
        } catch (\Throwable $exception) {
            throw new CannotCreateUser($exception);
        }

        return $user;
    }

    /**
     * @throws \Gamify\Exceptions\CannotCreateUser
     */
    private function assertEmailAddressIsUnique(string $emailAddress): bool
    {
        try {
            User::findByEmailAddress($emailAddress);
        } catch (ModelNotFoundException $exception) {
            return true;
        }

        throw CannotCreateUser::duplicateEmailAddress($emailAddress);
    }

    /**
     * @throws \Gamify\Exceptions\CannotCreateUser
     */
    private function assertUsernameIsUnique(string $username): bool
    {
        try {
            User::findByUsername($username);
        } catch (ModelNotFoundException $exception) {
            return true;
        }

        throw CannotCreateUser::duplicateUsername($username);
    }
}
