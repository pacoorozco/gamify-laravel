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

use Gamify\Question;
use Gamify\QuestionAction;
use Gamify\Http\Requests\QuestionActionCreateRequest;

class AdminQuestionActionController extends AdminController
{
    /**
     * Show the form for creating a new resource.
     *
     * @param Question $question
     *
     * @return \Illuminate\View\View
     */
    public function create(Question $question)
    {
        $availableActions = [];

        // get actions that hasn't not been used
        foreach ($question->getAvailableActions() as $action) {
            $availableActions[$action->id] = $action->name;
        }

        return view('admin/action/create', compact('question', 'availableActions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Question                    $question
     * @param QuestionActionCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Question $question, QuestionActionCreateRequest $request)
    {
        $question->actions()->create($request->all());

        return redirect()->route('admin.questions.edit', $question)
            ->with('success', trans('admin/action/messages.create.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question       $question
     * @param QuestionAction $action
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Question $question, QuestionAction $action)
    {
        $action->delete();

        return redirect()->route('admin.questions.edit', $question)
            ->with('success', trans('admin/action/messages.delete.success'));
    }
}
