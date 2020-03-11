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

namespace Gamify\Http\Controllers;

use Gamify\Level;
use Gamify\Libs\Game\Game;
use Gamify\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = User::find(Auth::id());
        $questions = $user->pendingQuestions(3);
        $usersInRanking = Game::getRanking();

        return view('dashboard.index', compact('user', 'questions', 'usersInRanking'));
    }

    /**
     * Return the ranking..
     *
     * @param \Illuminate\Http\Request     $request
     * @param \Yajra\Datatables\Datatables $dataTable
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     *
     */
    public function data(Request $request, Datatables $dataTable)
    {
        $users = User::select([
            'username',
            'name',
        ])
            //->with('points')
            //->sortbyDesc(function (User $user) {
            //  return $user->getExperiencePoints();
//            })
            ->take(10);

        return $dataTable->eloquent($users)
            ->addColumn('level', function (User $user) {
                return "level 0";
            })
            ->toJson();
    }
}
