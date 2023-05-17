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
use InvalidArgumentException;

class UsernameGeneratorService
{
    /**
     * Create the username from the received email.
     *
     * @throws InvalidArgumentException
     */
    public function fromEmail(string $email): string
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                'The value provided does not have a valid email format.'
            );
        }

        $username = preg_replace('/(@.*)$/', '', $email)
            ?? 'player';

        return $this->generateUniqueUsername($username);
    }

    /**
     * Create the username from the received text.
     */
    public function fromText(string $text): string
    {
        $username = empty($text)
            ? 'player'
            : $text;

        return $this->generateUniqueUsername($username);
    }

    /**
     * Check if the user already exists and return a differentiating number.
     */
    protected function generateUniqueUsername(string $username): string
    {
        $proposedUsername = $username;
        $existingUsernames = $this->findDuplicatedUsernames($username)
            ->pluck('username')
            ->toArray();

        while (in_array($proposedUsername, $existingUsernames, true)) {
            $suffix = strval((int) substr($proposedUsername, -1) + 1);
            $proposedUsername = $username.$suffix;
        }

        return $proposedUsername;
    }

    /**
     * Search for similar or repeated username.
     */
    protected function findDuplicatedUsernames(string $username): Collection
    {
        $lowercaseUsername = strtolower($username);

        return User::query()
            ->whereRaw('LOWER(username) LIKE ?', [$lowercaseUsername.'%'])
            ->orWhereRaw('LOWER(username) = ?', [$lowercaseUsername])
            ->get('username');
    }
}
