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

use Gamify\Events\UserProfileUpdated;
use Gamify\Http\Requests\ProfileUpdateRequest;
use Gamify\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function show(User $user): View
    {
        return view('profile.show')
            ->with('user', $user);
    }

    public function update(ProfileUpdateRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update-profile', $user);

        $user
            ->profile
            ->update($request->validated());

        UserProfileUpdated::dispatchIf($user->profile->wasChanged(), $user);

        return redirect()->route('profiles.show', $user->username)
            ->with('success', __('user/messages.settings_updated'));
    }
}
