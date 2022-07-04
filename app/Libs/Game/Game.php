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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Game
{
    public static function addExperienceTo(User $user, int $experience, string $reason): void
    {
        $user->points()->create([
            'points' => $experience,
            'description' => $reason,
        ]);
    }

    public static function incrementManyBadgesCount(User $user, Collection $badges): void
    {
        $badges->each(function ($badge) use ($user) {
            self::incrementBadgeCount($user, $badge);
        });
    }

    public static function incrementBadgeCount(User $user, Badge $badge): void
    {
        if ($user->hasUnlockedBadge($badge)) {
            return;
        }

        $progress = $user->progressToCompleteTheBadge($badge);

        $repetitions = $user->progressToCompleteTheBadge($badge)?->repetitions
            ?? 0;

        $repetitions++;

        if (is_null($progress)) {
            // this is the first occurrence of this badge for this user
            $user->badges()->attach($badge->id, [
                'repetitions' => $repetitions,
            ]);
        } else {
            // this badge was initiated before
            $user->badges()->updateExistingPivot($badge->id, [
                'repetitions' => $repetitions,
            ]);
        }

        if ($repetitions === $badge->required_repetitions) {
            self::unlockBadgeFor($user, $badge);
        }
    }

    public static function unlockBadgeFor(User $user, Badge $badge): void
    {
        if ($user->hasUnlockedBadge($badge)) {
            return;
        }

        $data = [
            'repetitions' => $badge->required_repetitions,
            'unlocked_at' => now(),
        ];

        try {
            $user->badges()
                ->wherePivot('badge_id', $badge->id)
                ->firstOrFail();

            // this badge was initiated before
            $user->badges()->updateExistingPivot($badge->id, $data);
        } catch (ModelNotFoundException $exception) {

            // this is the first occurrence of this badge for this user
            $user->badges()->attach($badge->id, $data);
        }
    }

    public static function getTopExperiencedPlayers(int $numberOfPlayers = 10): \Illuminate\Support\Collection
    {
        return User::query()
            ->player()
            ->select([
                'name',
                'username',
                'experience',
            ])
            ->orderBy('experience', 'DESC')
            ->take($numberOfPlayers)
            ->get()
            ->map(
                fn ($user) => [
                    'username' => $user->username,
                    'name' => $user->name,
                    'experience' => $user->experience,
                    'level' => $user->level,
                ]
            );
    }
}
