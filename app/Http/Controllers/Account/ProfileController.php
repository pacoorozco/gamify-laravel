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

namespace Gamify\Http\Controllers\Account;

use Gamify\Actions\UpdateUserProfileAction;
use Gamify\Http\Controllers\Controller;
use Gamify\Http\Requests\ProfileUpdateRequest;
use Gamify\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        return redirect()
            ->route('profiles.show', ['username' => $user->username]);
    }

    public function edit(): View
    {
        /** @var User $user */
        $user = Auth::user();

        return view('account.profile.edit')
            ->with('user', $user);
    }

    public function update(ProfileUpdateRequest $request, UpdateUserProfileAction $updateUserProfileAction): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $updateUserProfileAction->execute($user, $request->validated());

        return redirect()->route('account.index')
            ->with('success', __('user/messages.settings_updated'));
    }
}
