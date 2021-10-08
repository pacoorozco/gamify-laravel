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
use Yajra\Datatables\Datatables;

class AdminLevelController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin/level/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin/level/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LevelCreateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LevelCreateRequest $request)
    {
        try {
            Level::create($request->validated());
        } catch (\Exception $exception) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('admin/level/messages.create.error'));
        }

        return redirect()->route('admin.levels.index')
            ->with('success', __('admin/level/messages.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Level  $level
     * @return \Illuminate\View\View
     */
    public function show(Level $level)
    {
        return view('admin/level/show', compact('level'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Level  $level
     * @return \Illuminate\View\View
     */
    public function edit(Level $level)
    {
        return view('admin/level/edit', compact('level'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LevelUpdateRequest  $request
     * @param  Level  $level
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LevelUpdateRequest $request, Level $level)
    {
        try {
            $level->update($request->validated());
        } catch (\Exception $exception) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('admin/level/messages.update.error'));
        }

        return redirect()->route('admin.levels.index')
            ->with('success', __('admin/level/messages.update.success'));
    }

    /**
     * Remove level page.
     *
     * @param  Level  $level
     * @return \Illuminate\View\View
     */
    public function delete(Level $level)
    {
        return view('admin/level/delete', compact('level'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Gamify\Models\Level  $level
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function destroy(Level $level)
    {
        // Default level can not be deleted.
        if ($level->isDefault()) {
            return redirect()->back()
                ->with('error', __('admin/level/messages.delete.error_default_level'));
        }

        try {
            $level->delete();
        } catch (\Exception $exception) {
            return redirect()->back()
                ->with('error', __('admin/level/messages.delete.error'));
        }

        return redirect()->route('admin.levels.index')
            ->with('success', __('admin/level/messages.delete.success'));
    }

    /**
     * Show a list of all levels formatted for Datatables.
     *
     * @param  \Yajra\Datatables\Datatables  $dataTable
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function data(Datatables $dataTable)
    {
        $levels = Level::select([
            'id',
            'name',
            'required_points',
            'active',
            'image_url',
        ])->orderBy('required_points', 'ASC');

        return $dataTable->eloquent($levels)
            ->addColumn('image', function (Level $level) {
                return sprintf('<img src="%s" width="96" class="img-thumbnail" alt="%s">', $level->image, $level->name);
            })
            ->editColumn('active', function (Level $level) {
                return ($level->active) ? (string) __('general.yes') : (string) __('general.no');
            })
            ->addColumn('actions', function (Level $level) {
                return view('admin/partials.actions_dd')
                    ->with('model', 'levels')
                    ->with('id', $level->id)
                    ->render();
            })
            ->rawColumns(['actions', 'image'])
            ->removeColumn('id', 'image_url')
            ->toJson();
    }
}
