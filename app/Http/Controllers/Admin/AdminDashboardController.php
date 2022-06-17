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
use Gamify\Models\Level;
use Gamify\Models\Question;
use Gamify\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends AdminController
{
    public function index(): View
    {
        return view('admin.dashboard.index', [
            'badges_count' => Badge::active()->count(),
            'questions_count' => Question::published()->count(),
            'players_count' => User::player()->count(),
            'levels_count' => Level::active()->count(),
            'latest_users' => User::orderBy('created_at', 'desc')->take(5)->get(),
            'latest_questions' => Question::published()->orderBy('publication_date', 'desc')->take(5)->get(),
        ]);
    }
}
