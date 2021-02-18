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

namespace Gamify\Http\View\Composers;

use Gamify\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserSidebarComposer
{
    /** @var int */
    private $user_id;

    /**
     * Create a new User Dropdown composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user_id = Auth::id();
    }

    /**
     * Bind data to the view.
     *
     * @param \Illuminate\View\View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $user = User::findOrFail(
            $this->user_id,
            ['id']
        );

        $questions = $user->pendingQuestions();
        $questions_count = $questions->count();

        $view->with('questions_count', $questions_count);
    }
}
