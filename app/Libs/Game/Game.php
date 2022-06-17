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
use Gamify\Models\Level;
use Gamify\Models\Point;
use Gamify\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Game
{
    /**
     * Add experience to an user.
     *
     * @param  User  $user
     * @param  int  $points
     * @param  string  $message
     *
     * @return bool
     */
    public static function addReputation(User $user, int $points = 5, string $message = ''): bool
    {
        // add experience points to this user
        $point_entry = new Point([
            'points' => $points,
            'description' => (!empty($message)) ?: __('messages.unknown_reason'),
        ]);

        return ($user->points()->save($point_entry) === false) ?: true;
    }

    /**
     * Add more repetitions towards a collection of Badges.
     *
     * @param  \Gamify\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Collection  $badges
     */
    public static function incrementManyBadges(User $user, Collection $badges): void
    {
        foreach ($badges as $badge) {
            self::incrementBadge($user, $badge);
        }
    }

    /**
     * Give one more action towards a Badge for an User.
     *
     * @param  User  $user
     * @param  Badge  $badge
     *
     * @return void
     */
    public static function incrementBadge(User $user, Badge $badge): void
    {
        if ($user->hasBadgeCompleted($badge)) {
            return;
        }

        try {
            $userBadge = $user->badges()->wherePivot('badge_id', $badge->id)->firstOrFail();
            // this badge was initiated before
            $data['repetitions'] = $userBadge->pivot->repetitions + 1;
            $user->badges()->updateExistingPivot($badge->id, $data);
        } catch (ModelNotFoundException $exception) {
            // this is the first occurrence of this badge for this user
            $data['repetitions'] = 1;
            $user->badges()->attach($badge->id, $data);
        }

        if ($data['repetitions'] === $badge->required_repetitions) {
            self::giveCompletedBadge($user, $badge);
        }
    }

    /**
     * Give a completed Badge for an User.
     *
     * @param  User  $user
     * @param  Badge  $badge
     *
     * @return void
     */
    public static function giveCompletedBadge(User $user, Badge $badge): void
    {
        if ($user->hasBadgeCompleted($badge)) {
            return;
        }

        $data = [
            'repetitions' => $badge->required_repetitions,
            'completed' => true,
            'completed_on' => now(),
        ];

        try {
            $user->badges()->wherePivot('badge_id', $badge->id)->firstOrFail();
            // this badge was initiated before
            $user->badges()->updateExistingPivot($badge->id, $data);
        } catch (ModelNotFoundException $exception) {
            // this is the first occurrence of this badge for this user
            $user->badges()->attach($badge->id, $data);
        }
    }

    /**
     * Get a collection with members ordered by Experience Points.
     *
     * @param  int  $limitTopUsers
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getRanking(int $limitTopUsers = 10): \Illuminate\Support\Collection
    {
        return User::query()
            ->player()
            ->select([
                'name',
                'username',
                'experience',
            ])
            ->orderBy('experience', 'DESC')
            ->take($limitTopUsers)
            ->get()
            ->map(function ($user) {
                return [
                    'username' => $user->username,
                    'name' => $user->name,
                    'experience' => $user->experience,
                    'level' => $user->level,
                ];
            });
    }
}
