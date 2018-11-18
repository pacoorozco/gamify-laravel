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
 * @link               https://github.com/pacoorozco/gamify-l5
 */

namespace Gamify\Http\Controllers\Admin;

use Gamify\User;
use Gamify\Badge;
use Gamify\Http\Controllers\Game;
use Gamify\Http\Requests\RewardBadgeRequest;
use Gamify\Http\Requests\RewardExperienceRequest;

class AdminRewardController extends AdminController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::Member()->pluck('username', 'id');
        $badges = Badge::all()->pluck('name', 'id');

        return view('admin.reward.index', compact('users', 'badges'));
    }

    /**
     * @param \Gamify\Http\Requests\RewardExperienceRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function giveExperience(RewardExperienceRequest $request)
    {
        $user = User::findOrFail($request->input('username'));
        $points = $request->input('points');
        $message = $request->input('message');

        if (Game::addExperience($user, $points, $message)) {
            return redirect()->route('admin.rewards.index')
                ->with('success',
                    trans('admin/reward/messages.experience_given.success', [
                        'username' => $user->username,
                        'points'   => $points,
                    ]));
        } else {
            return redirect()->route('admin.rewards.index')
                ->with('error',
                    trans('admin/reward/messages.experience_given.error', [
                        'username' => $user->username,
                        'points'   => $points,
                    ]));
        }
    }

    /**
     * @param \Gamify\Http\Requests\RewardBadgeRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function giveBadge(RewardBadgeRequest $request)
    {
        $user = User::findOrFail($request->input('username'));
        $badge = Badge::findOrFail($request->input('badge'));

        if (Game::incrementBadge($user, $badge)) {
            return redirect()->route('admin.rewards.index')
                ->with('success',
                    trans('admin/reward/messages.badge_given.success', [
                        'username' => $user->username,
                        'badge'    => $badge->name,
                    ]));
        } else {
            return redirect()->route('admin.rewards.index')
                ->with('error',
                    trans('admin/reward/messages.badge_given.error', [
                        'username' => $user->username,
                    ]));
        }
    }
}
