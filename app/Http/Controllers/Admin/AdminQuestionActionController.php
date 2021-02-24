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

use Gamify\Enums\QuestionActuators;
use Gamify\Http\Requests\QuestionActionCreateRequest;
use Gamify\Models\Question;
use Gamify\Models\QuestionAction;

class AdminQuestionActionController extends AdminController
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  Question  $question
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function create(Question $question)
    {
        $availableActions = [];

        // get actions that hasn't not been used
        foreach ($question->getAvailableActions() as $action) {
            $availableActions[$action->id] = $action->name;
        }

        return view('admin/action/create', [
            'question' => $question,
            'availableActions' => $availableActions,
            'actuators' => QuestionActuators::asSelectArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Question  $question
     * @param  QuestionActionCreateRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Question $question, QuestionActionCreateRequest $request)
    {
        $question->actions()->create($request->validated());

        return redirect()->route('admin.questions.edit', $question)
            ->with('success', __('admin/action/messages.create.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Question  $question
     * @param  QuestionAction  $action
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Question $question, QuestionAction $action)
    {
        $action->delete();

        return redirect()->route('admin.questions.edit', $question)
            ->with('success', __('admin/action/messages.delete.success'));
    }
}
