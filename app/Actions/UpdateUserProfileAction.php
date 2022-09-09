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

use Gamify\Events\UserProfileUpdated;
use Gamify\Models\User;

final class UpdateUserProfileAction
{
    public function execute(User $user, array $attributes): User
    {
        $user->update([
            'name' => $attributes['name'],
        ]);

        $user->profile
            ->update($attributes);

        UserProfileUpdated::dispatchIf(
            $user->wasChanged('name') || $user->profile->wasChanged(),
            $user
        );

        return $user;
    }
}
