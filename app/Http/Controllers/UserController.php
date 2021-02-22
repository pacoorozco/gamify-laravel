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

namespace Gamify\Http\Controllers;

use Gamify\Http\Requests\UserProfileUpdateRequest;
use Gamify\Models\User;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        $questions_count = $user->pendingQuestions()->count();

        return view('profile.show', compact('user', 'questions_count'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserProfileUpdateRequest $request
     * @param User                     $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserProfileUpdateRequest $request, User $user)
    {
        $user->profile->fill($request->all())->save();

        return redirect()->route('profiles.show', $user->username)
            ->with('success', __('user/messages.settings_updated'));
    }
}
