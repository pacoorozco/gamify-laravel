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

use Gamify\User;
use Gamify\UserProfile;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Gamify\Http\Requests\UserCreateRequest;
use Gamify\Http\Requests\UserUpdateRequest;

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
        // Create User
        $user = new User();
        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->password = $request->input('password');

        if (! $user->save()) {
            return redirect()->back()
                ->withInput()
                ->with('error', trans('admin/user/messages.create.error'));
        }

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
        // Update User
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');

        if (! empty($request->input('password'))) {
            $user->password = $request->input('password');
        }

        if (! $user->save()) {
            return redirect()->back()
                ->withInput()
                ->with('error', trans('admin/user/messages.edit.error'));
        }

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
        if ($user->id === Auth::user()->id) {
            return redirect()->route('admin.users.index')
                ->with('error', trans('admin/user/messages.delete.impossible'));
        }

        if ($user->delete() !== true) {
            return redirect()->back()
                ->with('error', trans('admin/user/messages.delete.error'));
        }

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
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function data(Request $request, Datatables $dataTable)
    {
        // Disable this query if isn't AJAX
        if (! $request->ajax()) {
            return response('Forbidden.', 403);
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
                return view('admin/partials.actions_dd')
                    ->with('model', 'users')
                    ->with('id', $user->id)
                    ->render();
            })
            ->rawColumns(['actions'])
            ->removeColumn('id')
            ->make(true);
    }
}
