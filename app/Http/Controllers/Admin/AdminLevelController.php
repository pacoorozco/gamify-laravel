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

use Gamify\Http\Requests\LevelCreateRequest;
use Gamify\Http\Requests\LevelUpdateRequest;
use Gamify\Models\Level;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminLevelController extends AdminController
{
    public function index(): View
    {
        return view('admin.level.index');
    }

    public function store(LevelCreateRequest $request): RedirectResponse
    {
        Level::create($request->validated());

        return redirect()->route('admin.levels.index')
            ->with('success', __('admin/level/messages.create.success'));
    }

    public function create(): View
    {
        return view('admin.level.create');
    }

    public function show(Level $level): View
    {
        return view('admin.level.show', compact('level'));
    }

    public function edit(Level $level): View
    {
        return view('admin.level.edit', compact('level'));
    }

    public function update(LevelUpdateRequest $request, Level $level): RedirectResponse
    {
        $level->update($request->validated());

        return redirect()->route('admin.levels.index')
            ->with('success', __('admin/level/messages.update.success'));
    }

    public function destroy(Level $level): RedirectResponse
    {
        $level->delete();

        return redirect()->route('admin.levels.index')
            ->with('success', __('admin/level/messages.delete.success'));
    }
}
