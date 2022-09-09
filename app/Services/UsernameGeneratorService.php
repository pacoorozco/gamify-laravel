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

namespace Gamify\Services;

use Gamify\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UsernameGeneratorService
{
    /**
     * Create the username from the received email.
     *
     * @param  string  $email
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function fromEmail(string $email): string
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(
                'The value provided does not have a valid email format.'
            );
        }

        $username = preg_replace('/(@.*)$/', '', $email)
            ?? 'player';

        return $username.$this->getUsernamePrefix($username);
    }

    /**
     * Check if the user already exists and return a differentiating number.
     *
     * @param  string  $username
     * @return string
     */
    protected function getUsernamePrefix(string $username): string
    {
        $length = strlen($username);
        $users = $this->findDuplicateUsername($username);
        $prefix = '';

        if ($users->isNotEmpty()) {
            $users = $users->filter(function ($user) use ($length) {
                return is_numeric(
                    substr($user->username, $length)
                );
            });

            if ($users->isNotEmpty()) {
                $user = $users
                    ->sortByDesc(function ($user) use ($length) {
                        return substr($user->username, $length);
                    })
                    ->first();

                $prefix = strval((int) substr($user->username, $length) + 1);
            } else {
                $prefix = '1';
            }
        }

        return $prefix;
    }

    /**
     * Search for similar or repeated username.
     *
     * @param  string  $username
     * @return Collection
     */
    protected function findDuplicateUsername(string $username): Collection
    {
        $duplicate = User::query()
            ->where('username', $username)
            ->get('username');

        return $duplicate->isNotEmpty()
            ? User::query()
                ->where('username', 'LIKE', "$username%")
                ->get('username')
            : $duplicate;
    }

    /**
     * Create the username from the received text.
     *
     * @param  string  $text
     * @return string
     */
    public function fromText(string $text): string
    {
        $username = empty($text)
            ? 'player'
            : $text;

        return $username.$this->getUsernamePrefix($username);
    }
}
