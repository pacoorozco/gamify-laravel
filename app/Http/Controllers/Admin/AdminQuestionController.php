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
use Gamify\Enums\QuestionActuators;
use Gamify\Exceptions\QuestionPublishingException;
use Gamify\Http\Requests\QuestionCreateRequest;
use Gamify\Http\Requests\QuestionUpdateRequest;
use Gamify\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.question.create', [
            'availableTags' => Question::allTagModels()->pluck('name', 'normalized')->toArray(),
            'globalActions' => Badge::withActuatorsIn(QuestionActuators::asArray())->get(),
        ]);
    }

    /**
     * Stores new question.
     *
     * @param  QuestionCreateRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(QuestionCreateRequest $request): RedirectResponse
    {
        $question = Question::make([
            'name' => $request->input('name'),
            'question' => $request->input('question'),
            'solution' => $request->input('solution'),
            'type' => $request->input('type'),
            'hidden' => $request->input('hidden'),
            'publication_date' => $request->filled('publication_date')
                ? Carbon::createFromFormat('Y-m-d H:i', $request->input('publication_date'))
                : null,
        ]);

        DB::beginTransaction();
        try {
            $question->saveOrFail();

            // Store tags
            if ($request->has('tags')) {
                $question->tag($request->input('tags'));
            }

            // Store question choices
            if ($request->has('choices')) {
                $this->addChoicesToQuestion($question, $request->input('choices'));
            }

            if ($request->input('status') == Question::PUBLISH_STATUS) {
                $question->publish(); // throws exception on error.
            }
        } catch (QuestionPublishingException $exception) {
            DB::commit();

            return redirect(route('admin.questions.edit', $question))
                ->with('error', __('admin/question/messages.publish.error'));
        } catch (\Throwable $exception) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', __('admin/question/messages.create.error'));
        }
        DB::commit();

        return redirect()->route('admin.questions.index')
            ->with('success', __('admin/question/messages.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Question  $question
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
     * @param  Question  $question
     *
     * @return \Illuminate\View\View
     */
    public function edit(Question $question)
    {
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
            'globalActions' => Badge::withActuatorsIn(QuestionActuators::asArray())->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  QuestionUpdateRequest  $request
     * @param  Question  $question
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuestionUpdateRequest $request, Question $question)
    {
        $question->fill([
            'name' => $request->input('name'),
            'question' => $request->input('question'),
            'solution' => $request->input('solution'),
            'type' => $request->input('type'),
            'hidden' => $request->input('hidden'),
            'publication_date' => $request->filled('publication_date')
                ? Carbon::createFromFormat('Y-m-d H:i', $request->input('publication_date'))
                : null,
        ]);
        try {
            $question->saveOrFail();

            // Save Question Tags
            if (is_array($request->input('tags'))) {
                $question->retag($request->input('tags'));
            } else {
                $question->detag();
            }

            // Save Question Choices
            if ($request->has('choices')) {
                $this->addChoicesToQuestion($question, $request->input('choices'));
            }

            switch ($request->input('status')) {
                case 'publish':
                    $question->publish(); // throws exception on error.
                    break;
                case 'draft':
                    $question->transitionToDraftStatus(); // throws exception on error.
            }
        } catch (QuestionPublishingException $exception) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('admin/question/messages.publish.error'));
        } catch (\Throwable $exception) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('admin/question/messages.update.error'));
        }

        return redirect()->route('admin.questions.index')
            ->with('success', __('admin/question/messages.update.success'));
    }

    /**
     * Sync the given array of QuestionChoices to a Question.
     *
     * @param  \Gamify\Models\Question  $question
     * @param  array  $choices
     */
    private function addChoicesToQuestion(Question $question, array $choices): void
    {
        if ($question->choices()->count() > 0) {
            $question->choices()->delete();
        }

        if (count($choices) > 0) {
            $question->choices()->createMany($choices);
        }
    }

    /**
     * Remove question page.
     *
     * @param  Question  $question
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
     * @param  Question  $question
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
     * @param  \Yajra\Datatables\Datatables  $dataTable
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
                return $question->present()->statusBadge . ' ' . $question->present()->visibilityBadge;
            })
            ->editColumn('name', function (Question $question) {
                return $question->present()->name . ' ' . $question->present()->publicUrlLink;
            })
            ->editColumn('type', function (Question $question) {
                return $question->present()->typeIcon;
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
}
