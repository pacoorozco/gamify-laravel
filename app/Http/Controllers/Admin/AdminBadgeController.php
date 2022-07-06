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

use Gamify\Http\Requests\BadgeCreateRequest;
use Gamify\Http\Requests\BadgeUpdateRequest;
use Gamify\Models\Badge;
use Gamify\Presenters\BadgePresenter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class AdminBadgeController extends AdminController
{
    public function index(): View
    {
        return view('admin.badge.index');
    }

    public function store(BadgeCreateRequest $request): RedirectResponse
    {
        Badge::create([
            'name' => $request->name(),
            'description' => $request->description(),
            'required_repetitions' => $request->repetitions(),
            'active' => $request->active(),
            'actuators' => $request->actuators(),
        ]);

        return redirect()->route('admin.badges.index')
            ->with('success', __('admin/badge/messages.create.success'));
    }

    public function create(): View
    {
        return view('admin.badge.create', [
            'actuators_list' => BadgePresenter::actuatorsSelect(),
            'selected_actuators' => null,
        ]);
    }

    public function show(Badge $badge): View
    {
        return view('admin.badge.show')
            ->with('badge', $badge);
    }

    public function edit(Badge $badge): View
    {
        return view('admin.badge.edit')
            ->with('badge', $badge)
            ->with('actuators_list', BadgePresenter::actuatorsSelect())
            ->with('selected_actuators', Arr::pluck($badge->present()->actuators, 'value'));
    }

    public function update(BadgeUpdateRequest $request, Badge $badge): RedirectResponse
    {
        $badge->update([
            'name' => $request->name(),
            'description' => $request->description(),
            'required_repetitions' => $request->repetitions(),
            'active' => $request->active(),
            'actuators' => $request->actuators(),
        ]);

        return redirect()->route('admin.badges.index')
            ->with('success', __('admin/badge/messages.update.success'));
    }

    public function destroy(Badge $badge): RedirectResponse
    {
        $badge->delete();

        return redirect()->route('admin.badges.index')
            ->with('success', __('admin/badge/messages.delete.success'));
    }

    public function delete(Badge $badge): View
    {
        return view('admin.badge.delete')
            ->with('badge', $badge);
    }
}
