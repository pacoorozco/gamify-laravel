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

namespace Gamify\Http\Controllers\Admin;

use Gamify\Http\Requests\RewardBadgeRequest;
use Gamify\Http\Requests\RewardExperienceRequest;
use Gamify\Libs\Game\Game;
use Gamify\Models\Badge;
use Gamify\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminRewardController extends AdminController
{
    public function index(): View
    {
        $users = User::Member()->pluck('username', 'id');
        $badges = Badge::all()->pluck('name', 'id');

        return view('admin.reward.index', compact('users', 'badges'));
    }

    public function giveExperience(RewardExperienceRequest $request): RedirectResponse
    {
        /** @var \Gamify\Models\User $user */
        $user = User::findOrFail($request->input('username'));
        $points = $request->input('points');
        $message = $request->input('message');

        if (! Game::addReputation($user, $points, $message)) {
            return redirect()->back()
                ->withInput()
                ->with('error',
                    trans('admin/reward/messages.experience_given.error', [
                        'username' => $user->username,
                    ]));
        }

        return redirect()->route('admin.rewards.index')
            ->with('success',
                trans('admin/reward/messages.experience_given.success', [
                    'username' => $user->username,
                    'points'   => $points,
                ]));
    }

    public function giveBadge(RewardBadgeRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = User::findOrFail($request->input('badge_username'));
        /** @var Badge $badge */
        $badge = Badge::findOrFail($request->input('badge'));

        Game::incrementBadge($user, $badge);

        return redirect()->route('admin.rewards.index')
            ->with('success',
                trans('admin/reward/messages.badge_given.success', [
                    'username' => $user->username,
                    'badge'    => $badge->name,
                ]));
    }
}
