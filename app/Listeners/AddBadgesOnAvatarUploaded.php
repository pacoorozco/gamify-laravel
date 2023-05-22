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

namespace Gamify\Listeners;

use Gamify\Enums\BadgeActuators;
use Gamify\Events\AvatarUploaded;
use Gamify\Libs\Game\Game;
use Gamify\Models\Badge;

class AddBadgesOnAvatarUploaded
{
    public function handle(AvatarUploaded $event): void
    {
        $user = $event->user;

        Badge::query()
            ->whereActuators(BadgeActuators::OnUserAvatarUploaded)
            ->get()
            ->each(function ($badge) use ($user) {
                Game::incrementBadgeCount($user, $badge);
            });
    }
}
