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

use Gamify\Models\Question;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class AdminQuestionDataTablesController extends AdminController
{
    public function __invoke(Datatables $dataTable): JsonResponse
    {
        $questions = Question::select([
            'id',
            'short_name',
            'name',
            'status',
            'hidden',
            'publication_date',
        ])->orderBy('name', 'ASC');

        return $dataTable->eloquent($questions)
            ->editColumn('status', function (Question $question) {
                return $question->present()->statusBadge.' '.$question->present()->visibilityBadge;
            })
            ->editColumn('name', function (Question $question) {
                return $question->present()->name.' '.$question->present()->publicUrlLink;
            })
            ->editColumn('publication_date', function (Question $question) {
                return $question->present()->publicationDate();
            })
            ->addColumn('tags', function (Question $question) {
                return $question->present()->tags();
            })
            ->addColumn('actions', function (Question $question) {
                return view('admin/partials.actions_dd')
                    ->with('model', 'questions')
                    ->with('id', $question->id)
                    ->render();
            })
            ->rawColumns(['actions', 'status', 'name', 'tags'])
            ->removeColumn(['id', 'hidden', 'short_name'])
            ->toJson();
    }
}
