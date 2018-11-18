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

use Gamify\Http\Requests\UserCreateRequest;
use Gamify\Http\Requests\UserUpdateRequest;
use Gamify\User;
use Gamify\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class AdminUserController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin/user/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin/user/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Gamify\Http\Requests\UserCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserCreateRequest $request)
    {
        $user = User::create($request->all());

        // Insert related models
        $profile = new UserProfile();
        $user->profile()->save($profile);

        return redirect()->route('admin.users.index')
            ->with('success', trans('admin/user/messages.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param \Gamify\User $user
     *
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('admin/user/show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Gamify\User $user
     *
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('admin/user/edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Gamify\Http\Requests\UserUpdateRequest $request
     * @param \Gamify\User                            $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->fill($request->all())->save();

        return redirect()->route('admin.users.edit', $user)
            ->with('success', trans('admin/user/messages.edit.success'));
    }

    /**
     * Remove user.
     *
     * @param \Gamify\User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(User $user)
    {
        return view('admin/user/delete', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Gamify\User $user
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // Can't remove myself
        if ($user->id == Auth::user()->id) {
            return redirect()->route('admin.users.index')
                ->with('error', trans('admin/user/messages.delete.error'));
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', trans('admin/user/messages.delete.success'));
    }

    /**
     * Show a list of all the users formatted for Datatables.
     *
     * @param \Illuminate\Http\Request     $request
     * @param \Yajra\Datatables\Datatables $dataTable
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function data(Request $request, Datatables $dataTable)
    {
        // Disable this query if isn't AJAX
        if (!$request->ajax()) {
            abort(400);
        }

        $users = User::select([
            'id',
            'name',
            'username',
            'email',
            'role',
        ])->orderBy('username', 'ASC');

        return $dataTable->of($users)
            ->addColumn('actions', function (User $user) {
                return view('admin/partials.actions_dd', [
                    'model' => 'users',
                    'id'    => $user->id,
                ])->render();
            })
            ->removeColumn('id')
            ->make(true);
    }
}
