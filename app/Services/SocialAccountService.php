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

use Gamify\Enums\Roles;
use Gamify\Jobs\CreateUser;
use Gamify\Models\LinkedSocialAccount;
use Gamify\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as ExternalUser;

class SocialAccountService
{
    /**
     * Returns the User object authenticated by a social login.
     * If the user didn't exist, it will be created.
     *
     * @param  \Laravel\Socialite\Contracts\User  $externalUser
     * @param  string  $provider
     * @return \Gamify\Models\User
     */
    public function findOrCreate(ExternalUser $externalUser, string $provider): User
    {
        $account = LinkedSocialAccount::query()
            ->where('provider_name', $provider)
            ->where('provider_id', $externalUser->getId())
            ->first();

        if (! is_null($account?->user)) {
            return $account->user;
        }

        return $this->createSocialAccount($externalUser, $provider);
    }

    private function createSocialAccount(ExternalUser $providerUser, string $provider): User
    {
        /** @var User $user */
        $user = User::query()
            ->where('email', $providerUser->getEmail())
            ->first();

        if (! ($user instanceof User)) {
            $user = CreateUser::dispatchSync(
                $this->getUniqueUsername($providerUser->getNickname()),
                $providerUser->getEmail(),
                $providerUser->getName(),
                '',
                Roles::Player,
            );
        }

        $user->accounts()->create([
            'provider_id' => $providerUser->getId(),
            'provider_name' => $provider,
        ]);

        return $user;
    }

    /**
     * Returns an unique username from a given base username.
     *
     * @param  string  $baseUsername
     * @return string
     */
    private function getUniqueUsername(string $baseUsername): string
    {
        $uniqueUsername = $baseUsername;
        while (User::where('username', $uniqueUsername)->exists()) {
            $uniqueUsername = $baseUsername . Str::random(2);
        }

        return $uniqueUsername;
    }
}
