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

use Gamify\Http\Requests\LevelCreateRequest;
use Gamify\Http\Requests\LevelUpdateRequest;
use Gamify\Level;
use Illuminate\Http\Request;
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
     * @param LevelCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LevelCreateRequest $request)
    {
        Level::create($request->all());

        return redirect()->route('admin.levels.index')
            ->with('success', trans('admin/level/messages.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param Level $level
     *
     * @return \Illuminate\View\View
     */
    public function show(Level $level)
    {
        return view('admin/level/show', compact('level'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Level $level
     *
     * @return \Illuminate\View\View
     */
    public function edit(Level $level)
    {
        return view('admin/level/edit', compact('level'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LevelUpdateRequest $request
     * @param Level              $level
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LevelUpdateRequest $request, Level $level)
    {
        $level->fill($request->all())->save();

        return redirect()->route('admin.levels.index')
            ->with('success', trans('admin/level/messages.update.success'));
    }

    /**
     * Remove level page.
     *
     * @param Level $level
     *
     * @return \Illuminate\View\View
     */
    public function delete(Level $level)
    {
        return view('admin/level/delete', compact('level'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Level $level
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Level $level)
    {
        $level->delete();

        return redirect()->route('admin.levels.index')
            ->with('success', trans('admin/level/messages.delete.success'));
    }

    /**
     * Show a list of all the levels formatted for Datatables.
     *
     * @param Request    $request
     * @param Datatables $dataTable
     *
     * @return Datatables JsonResponse
     */

    /**
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

        $levels = Level::select([
            'id',
            'name',
            'amount_needed',
            'active',
        ])->orderBy('amount_needed', 'ASC');

        return $dataTable::of($levels)
            ->addColumn('image', function (Level $level) {
                $level = Level::find($level->id);

                return '<img src="'.$level->image->url('small').'" width="64" class="img-thumbnail" />';
            })
            ->editColumn('active', function (Level $level) {
                return ($level->active) ? trans('general.yes') : trans('general.no');
            })
            ->addColumn('actions', function (Level $level) {
                return view('admin/partials.actions_dd', [
                    'model' => 'levels',
                    'id'    => $level->id,
                ])->render();
            })
            ->removeColumn('id')
            ->make(true);

        return View::make()->render();
    }
}
