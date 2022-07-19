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

use Gamify\Models\Badge;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class AdminBadgeDataTablesController extends AdminController
{
    public function __invoke(Datatables $dataTable): JsonResponse
    {
        $badges = Badge::select([
            'id',
            'name',
            'required_repetitions',
            'active',
            'image_url',
        ])->orderBy('name', 'ASC');

        return $dataTable->eloquent($badges)
            ->editColumn('name', function (Badge $badge) {
                return $badge->present()->nameWithStatusBadge;
            })
            ->addColumn('image', function (Badge $badge) {
                return $badge->present()->imageTableThumbnail;
            })
            ->editColumn('active', function (Badge $badge) {
                return $badge->present()->status;
            })
            ->addColumn('actions', function (Badge $badge) {
                return view('admin.partials.actions_dd')
                    ->with('model', 'badges')
                    ->with('id', $badge->id)
                    ->render();
            })
            ->rawColumns(['name', 'actions', 'image'])
            ->removeColumn('id', 'image_url')
            ->toJson();
    }
}
