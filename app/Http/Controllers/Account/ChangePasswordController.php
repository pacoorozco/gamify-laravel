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

use Gamify\Actions\UpdatePasswordAction;
use Gamify\Http\Controllers\Controller;
use Gamify\Http\Requests\UpdatePasswordRequest;
use Gamify\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChangePasswordController extends Controller
{
    public function index(): View
    {
        return view('account.password.index');
    }

    public function update(UpdatePasswordRequest $request, UpdatePasswordAction $updatePasswordAction): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $updatePasswordAction->execute($user, $request->newPassword());

        return redirect()->action([static::class, 'index'])
            ->with('success', __('passwords.changed'));
    }
}
