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

use Gamify\Http\Requests\QuestionCreateRequest;
use Gamify\Http\Requests\QuestionUpdateRequest;
use Gamify\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Yajra\Datatables\Datatables;

class AdminQuestionController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('admin.question.index');
    }

    /**
     * Displays the form for question creation.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('admin.question.create', [
            'availableTags' => Question::allTagModels()->pluck('name', 'normalized')->toArray(),
        ]);
    }

    /**
     * Stores new question.
     *
     * @param QuestionCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(QuestionCreateRequest $request): RedirectResponse
    {
        try {
            $question = Question::create($request->only([
                'name',
                'question',
                'solution',
                'type',
                'hidden',
            ]));

            // The request is an array, validation has ensured it.
            if ($request->has('tags')) {
                $question->tag($request->input('tags'));
            }

            // Save Question Choices
            $question->choices()->createMany($this->prepareQuestionChoices($request->input('choice_text'), $request->input('choice_score')));
        } catch (\Exception $exception) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('admin/question/messages.create.error'));
        }

        return redirect()->route('admin.questions.index')
            ->with('success', __('admin/question/messages.create.success'));
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
        return view('admin/question/show', [
            'question' => $question,
        ]);
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
        //$selectedTagsArray = $question->tagArray;
        //$selectedTags = array_combine($selectedTagsArray, $selectedTagsArray);

        $availableActions = [];
        // get actions that hasn't not been used
        foreach ($question->getAvailableActions() as $action) {
            $availableActions[$action->id] = $action->name;
        }

        return view('admin/question/edit', [
            'question' => $question,
            'availableTags' => Question::allTagModels()->pluck('name', 'normalized')->toArray(),
            'selectedTags' => $question->tagArray,
            'availableActions' => $availableActions,
        ]);
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
        $question->choices()->createMany($this->prepareQuestionChoices($request->input('choice_text'), $request->input('choice_score')));

        // Are you trying to publish a question?
        if ($request->input('status') == 'publish') {
            if (! $question->canBePublished()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', __('admin/question/messages.publish.error'));
            }
        }
        $question->fill($request->only(['name', 'question', 'solution', 'type', 'hidden', 'status']));

        if (! $question->save()) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('admin/question/messages.update.error'));
        }

        return redirect()->route('admin.questions.index')
            ->with('success', __('admin/question/messages.update.success'));
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
        return view('admin/question/delete', [
            'question' => $question,
        ]);
    }

    /**
     * Remove the specified question from storage.
     *
     * @param Question $question
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Question $question)
    {
        try {
            $question->delete();
        } catch (\Exception $exception) {
            return redirect()->back()
                ->with('error', __('admin/question/messages.delete.error'));
        }

        return redirect()->route('admin.questions.index')
            ->with('success', __('admin/question/messages.delete.success'));
    }

    /**
     * Show a list of all the questions formatted for Datatables.
     *
     * @param \Yajra\Datatables\Datatables $dataTable
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function data(Datatables $dataTable)
    {
        $question = Question::select([
            'id',
            'short_name',
            'name',
            'status',
            'hidden',
            'type',
        ])->orderBy('name', 'ASC');

        return $dataTable->eloquent($question)
            ->editColumn('status', function (Question $question) {
                return view('admin/question/partials._add_status_and_visibility_labels')
                    ->with('status', $question->status)
                    ->with('hidden', $question->hidden)
                    ->render();
            })
            ->editColumn('name', function (Question $question) {
                return view('admin/question/partials._question_name_with_link')
                    ->with('name', $question->name)
                    ->with('url', $question->public_url)
                    ->render();
            })
            ->editColumn('type', function (Question $question) {
                return view('admin/question/partials._question_type')
                    ->with('type', $question->type)
                    ->render();
            })
            ->addColumn('actions', function (Question $question) {
                return view('admin/partials.actions_dd')
                    ->with('model', 'questions')
                    ->with('id', $question->id)
                    ->render();
            })
            ->rawColumns(['actions', 'status', 'name', 'type'])
            ->removeColumn(['id', 'hidden', 'short_name'])
            ->toJson();
    }

    /**
     * Return an array of choices to be associated to a Question.
     *
     * @param array $choice_texts  - Text of the choices
     * @param array $choice_scores - Score of the choices
     *
     * @return array
     */
    private function prepareQuestionChoices(array $choice_texts, $choice_scores): array
    {
        $numberOfChoices = count($choice_texts);
        $choices = [];
        for ($i = 0; $i < $numberOfChoices; $i++) {
            if (empty($choice_texts[$i])) {
                continue;
            }

            array_push($choices, [
                'text' => $choice_texts[$i],
                'score' => is_numeric($choice_scores[$i]) ? $choice_scores[$i] : 0,
                'correct' => ($choice_scores[$i] > 0),
            ]);
        }

        return $choices;
    }
}
