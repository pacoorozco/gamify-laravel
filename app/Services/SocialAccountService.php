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

use Gamify\Models\LinkedSocialAccount;
use Gamify\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    /**
     * Returns the User object authenticated by a social login.
     * If the user didn't exist, it will be created.
     *
     * @param  \Laravel\Socialite\Contracts\User  $providerUser
     * @param  string  $provider
     * @return \Gamify\Models\User
     */
    public function findOrCreate(ProviderUser $providerUser, string $provider): User
    {
        $account = LinkedSocialAccount::where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        }

        $user = User::where('email', $providerUser->getEmail())->first();

        if (! $user) {
            $user = User::create([
                'email' => $providerUser->getEmail(),
                'name' => $providerUser->getName(),
                'username' => $this->generateUsernameFromEmail($providerUser->getEmail()),
            ]);

            $user->profile()->create([
                'avatar' => asset('images/missing_profile.png'),
            ]);
        }

        $user->accounts()->create([
            'provider_id' => $providerUser->getId(),
            'provider_name' => $provider,
        ]);

        return $user;
    }

    /**
     * Returns an unique username from the given email.
     *
     * @param  string  $email
     * @return string
     */
    private function generateUsernameFromEmail(string $email): string
    {
        $username = Str::before($email, '@');
        $uniqueUsername = $username;
        while (User::where('username', $uniqueUsername)->first(['id'])) {
            $uniqueUsername = $username . Str::random(2);
        }

        return $uniqueUsername;
    }
}
