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

use Gamify\Badge;
use Gamify\Question;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Gamify\Http\Requests\QuestionCreateRequest;
use Gamify\Http\Requests\QuestionUpdateRequest;

class AdminQuestionController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin/question/index');
    }

    /**
     * Displays the form for question creation.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $availableTagArray = Question::allTags();
        $availableTags = array_combine($availableTagArray, $availableTagArray);
        $selectedTags = [];

        $availableActions = [];
        // get actions that hasn't not been used
        foreach (Badge::all() as $action) {
            $availableActions[$action->id] = $action->name;
        }

        return view('admin/question/create', compact('availableTags', 'selectedTags', 'availableActions'));
    }

    /**
     * Stores new question.
     *
     * @param QuestionCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(QuestionCreateRequest $request)
    {
        $question = new Question();
        $question->fill($request->only(['name', 'question', 'solution', 'type', 'hidden']));

        if (! $question->save()) {
            return redirect()->back()
                ->withInput()
                ->with('error', trans('admin/question/messages.create.error'));
        }

        // Save Question Tags
        if (is_array($request->input('tag_list'))) {
            $question->tag($request->input('tag_list'));
        }

        // Save Question Choices
        if (is_array($request->input('choice_text'))) {
            $choice_texts = $request->input('choice_text');
            $choice_scores = $request->input('choice_score');

            $numberOfChoices = count($choice_texts);
            for ($i = 0; $i < $numberOfChoices; $i++) {
                if (empty($choice_texts[$i])) {
                    continue;
                }

                if (is_null($choice_scores[$i])) {
                    $choice_scores[$i] = 0;
                }

                $question->choices()->create([
                    'text'    => $choice_texts[$i],
                    'score'   => $choice_scores[$i],
                    'correct' => ($choice_scores[$i] > 0),
                ]);
            }
        }

        return redirect()->route('admin.questions.index')
            ->with('success', trans('admin/question/messages.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     *
     * @return \Illuminate\View\View
     */
    public function show(Question $question)
    {
        return view('admin/question/show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Question $question
     *
     * @return \Illuminate\View\View
     */
    public function edit(Question $question)
    {
        $availableTagArray = Question::allTags();
        $availableTags = array_combine($availableTagArray, $availableTagArray);
        $selectedTagsArray = $question->tagArray;
        $selectedTags = array_combine($selectedTagsArray, $selectedTagsArray);

        $availableActions = [];
        // get actions that hasn't not been used
        foreach ($question->getAvailableActions() as $action) {
            $availableActions[$action->id] = $action->name;
        }

        return view('admin/question/edit', compact('question', 'availableTags', 'selectedTags', 'availableActions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuestionUpdateRequest $request
     * @param Question              $question
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuestionUpdateRequest $request, Question $question)
    {
        // Save Question Tags
        if (is_array($request->input('tag_list'))) {
            $question->retag($request->input('tag_list'));
        } else {
            $question->detag();
        }

        // Save Question Choices
        // 1st. Deletes the old ones
        $question->choices()->delete();
        // 2nd. Adds the new ones

        if (is_array($request->input('choice_text'))) {
            $choice_texts = $request->input('choice_text');
            $choice_scores = $request->input('choice_score');

            $numberOfChoices = count($choice_texts);
            for ($i = 0; $i < $numberOfChoices; $i++) {
                if (empty($choice_texts[$i])) {
                    continue;
                }

                if (is_null($choice_scores[$i])) {
                    $choice_scores[$i] = 0;
                }

                $question->choices()->create([
                    'text'    => $choice_texts[$i],
                    'score'   => $choice_scores[$i],
                    'correct' => ($choice_scores[$i] > 0),
                ]);
            }
        }

        // Are you trying to publish a question?
        if ($request->input('status') == 'publish') {
            if (! $question->canBePublished()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', trans('admin/question/messages.publish.error'));
            }
        }
        $question->fill($request->only(['name', 'question', 'solution', 'type', 'hidden', 'status']));

        if (! $question->save()) {
            return redirect()->back()
                ->withInput()
                ->with('error', trans('admin/question/messages.update.error'));
        }

        return redirect()->route('admin.questions.index')
            ->with('success', trans('admin/question/messages.update.success'));
    }

    /**
     * Remove question page.
     *
     * @param Question $question
     *
     * @return \Illuminate\View\View
     */
    public function delete(Question $question)
    {
        return view('admin/question/delete', compact('question'));
    }

    /**
     * Remove the specified question from storage.
     *
     * @param Question $question
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Question $question)
    {
        if ($question->delete() !== true) {
            return redirect()->back()
                ->with('error', trans('admin/question/messages.delete.error'));
        }

        return redirect()->route('admin.questions.index')
            ->with('success', trans('admin/question/messages.delete.success'));
    }

    /**
     * Show a list of all the questions formatted for Datatables.
     *
     * @param \Illuminate\Http\Request     $request
     * @param \Yajra\Datatables\Datatables $dataTable
     *
     * @throws \Exception
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function data(Request $request, Datatables $dataTable)
    {
        // Disable this query if isn't AJAX
        if (! $request->ajax()) {
            return response('Forbidden.', 403);
        }

        $question = Question::select([
            'id',
            'short_name',
            'name',
            'status',
        ])->orderBy('name', 'ASC');

        $statusLabel = [
            'draft'     => '<span class="label label-default">'.trans('admin/question/model.status_list.draft').'</span>',
            'publish'   => '<span class="label label-success">'.trans('admin/question/model.status_list.publish').'</span>',
            'unpublish' => '<span class="label label-warning">'.trans('admin/question/model.status_list.unpublish').'</span>',
        ];

        return $dataTable->of($question)
            ->editColumn('status', function (Question $question) use ($statusLabel) {
                return $statusLabel[$question->status];
            })
            ->addColumn('actions', function (Question $question) {
                return view('admin/partials.actions_dd')
                    ->with('model', 'questions')
                    ->with('id', $question->id)
                    ->render();
            })
            ->rawColumns(['actions', 'status'])
            ->removeColumn('id')
            ->make(true);
    }
}
