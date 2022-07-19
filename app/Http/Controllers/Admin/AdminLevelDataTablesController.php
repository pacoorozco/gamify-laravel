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

use Gamify\Models\Level;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class AdminLevelDataTablesController extends AdminController
{
    public function __invoke(Datatables $dataTable): JsonResponse
    {
        $levels = Level::query()
            ->select([
                'id',
                'name',
                'required_points',
                'active',
            ])
            ->orderBy('required_points', 'ASC');

        return $dataTable->eloquent($levels)
            ->editColumn('name', function (Level $level) {
                return $level->present()->nameWithStatusBadge;
            })
            ->addColumn('image', function (Level $level) {
                return $level->present()->image;
            })
            ->editColumn('active', function (Level $level) {
                return $level->present()->status;
            })
            ->addColumn('actions', function (Level $level) {
                return view('admin/partials.actions_dd')
                    ->with('model', 'levels')
                    ->with('id', $level->id)
                    ->render();
            })
            ->rawColumns(['name', 'actions', 'image'])
            ->removeColumn('id')
            ->toJson();
    }
}
