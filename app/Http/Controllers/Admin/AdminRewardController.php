<?php

namespace Gamify\Http\Controllers\Admin;

use Gamify\Badge;
use Gamify\Http\Controllers\Game;
use Gamify\User;
use Gamify\Http\Requests;
use Gamify\Http\Requests\RewardExperienceRequest;
use Gamify\Http\Requests\RewardBadgeRequest;

class AdminRewardController extends AdminController
{
    public function index()
    {
        $users = User::Member()->lists('username', 'id');
        $badges = Badge::all()->lists('name', 'id');

        return view('admin.reward.index', compact('users', 'badges'));
    }

    public function giveExperience(RewardExperienceRequest $request)
    {
        $user = User::findOrFail($request->input('username'));
        $points = $request->input('points');
        $message = $request->input('message');

        Game::addExperience($user, $points, $message);

        return redirect()->route('admin.rewards.index')
            ->with('success',
                trans('admin/reward/messages.experience_given.success', [
                    'username' => $user->username,
                    'points' => $points
                ]));
    }

    public function giveBadge(RewardBadgeRequest $request)
    {
        $user = User::findOrFail($request->input('username'));
        $badge = Badge::findOrFail($request->input('badge'));

        if (Game::incrementBadge($user, $badge)) {
            return redirect()->route('admin.rewards.index')
                ->with('success',
                    trans('admin/reward/messages.badge_given.success', [
                        'username' => $user->username,
                        'badge' => $badge->name
                    ]));
        } else {
            return redirect()->route('admin.rewards.index')
                ->with('success',
                    trans('admin/reward/messages.badge_given.error', [
                        'username' => $user->username
                    ]));
        }
    }

}
