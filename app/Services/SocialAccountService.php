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

use Gamify\Actions\CreateUserAction;
use Gamify\Enums\Roles;
use Gamify\Models\LinkedSocialAccount;
use Gamify\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as ExternalUser;

class SocialAccountService
{
    /**
     * Returns the User object authenticated by a social login.
     * If the user doesn't exist, it will be created.
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

        if (is_null($account?->user)) {
            return $this->createSocialAccount($externalUser, $provider);
        }

        return $account->user;
    }

    private function createSocialAccount(
        ExternalUser $providerUser,
        string $provider
    ): User {
        /** @var User $user */
        $user = User::query()
            ->where('email', $providerUser->getEmail())
            ->firstOr(function () use ($providerUser) {
                $createUserAction = app()->make(CreateUserAction::class);

                return $createUserAction->execute(
                    User::generateUsername($providerUser->getNickname()),
                    $providerUser->getEmail(),
                    $providerUser->getName(),
                    password: Str::random(),
                    role: Roles::Player,
                    skipEmailVerification: true
                );
            });

        $user->accounts()->updateOrCreate([
            'provider_id' => $providerUser->getId(),
            'provider_name' => $provider,
        ]);

        return $user;
    }
}
