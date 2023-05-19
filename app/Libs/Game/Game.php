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

namespace Gamify\Libs\Game;

use Gamify\Models\Badge;
use Gamify\Models\User;
use Gamify\Notifications\BadgeUnlocked;
use Illuminate\Support\Collection;

class Game
{
    public static function incrementBadgeCount(User $user, Badge $badgeToIncrement): void
    {
        if ($user->hasUnlockedBadge($badgeToIncrement)) {
            return;
        }

        $progress = $user->progressToCompleteTheBadge($badgeToIncrement);
        $repetitions = $progress?->repetitions ?? 0;
        $repetitions++;

        $badgeData = ['repetitions' => $repetitions];

        $user->badges()->syncWithoutDetaching([
            $badgeToIncrement->id => $badgeData,
        ]);

        if ($repetitions === $badgeToIncrement->required_repetitions) {
            self::unlockBadgeFor($user, $badgeToIncrement);
        }
    }

    public static function unlockBadgeFor(User $user, Badge $badge): void
    {
        if ($user->hasUnlockedBadge($badge)) {
            return;
        }

        $badgeData = [
            'repetitions' => $badge->required_repetitions,
            'unlocked_at' => now(),
        ];

        $user->badges()->syncWithoutDetaching([
            $badge->id => $badgeData,
        ]);

        $user->notify(new BadgeUnlocked($badge));
    }

    public static function getTopExperiencedPlayers(int $maxNumberOfPlayers = 10): Collection
    {
        return User::query()
            ->player()
            ->select(['username', 'name'])
            ->withSum('points as total_points', 'points')
            ->orderByDesc('total_points')
            ->take($maxNumberOfPlayers)
            ->get()
            ->map(function ($user) {
                return [
                    'username' => $user->username,
                    'name' => $user->name,
                    'experience' => $user->total_points ?? 0,
                    'level' => $user->level,
                ];
            });
    }
}
