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

use Gamify\Actions\CreateUserAction;
use Gamify\Http\Requests\UserCreateRequest;
use Gamify\Http\Requests\UserUpdateRequest;
use Gamify\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AdminUserController extends AdminController
{
    public function index(): View
    {
        return view('admin/user/index');
    }

    public function create(): View
    {
        return view('admin/user/create');
    }

    public function store(UserCreateRequest $request, CreateUserAction $createUserAction): RedirectResponse
    {
        $createUserAction->execute(
            $request->username(),
            $request->email(),
            $request->name(),
            $request->password(),
            $request->role(),
            skipEmailVerification: true
        );

        return redirect()->route('admin.users.index')
            ->with('success', __('admin/user/messages.create.success'));
    }

    public function show(User $user): View
    {
        return view('admin/user/show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('admin/user/edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        // password is not changed if it's empty.
        $data = empty($request->input('password'))
            ? Arr::except($request->validated(), ['password'])
            : $request->validated();

        // users can't change its own role
        if (Gate::denies('update-role', $user)) {
            $data = Arr::except($data, ['role']);
        }

        $user->update($data);

        return redirect()->route('admin.users.edit', $user)
            ->with('success', __('admin/user/messages.edit.success'));
    }

    public function destroy(User $user): RedirectResponse
    {
        if (Gate::denies('delete-user', $user)) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', __('admin/user/messages.delete.success'));
    }

    public function delete(User $user): View
    {
        return view('admin/user/delete', compact('user'));
    }
}
