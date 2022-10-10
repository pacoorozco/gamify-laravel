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

use Gamify\Exceptions\QuestionPublishingException;
use Gamify\Http\Requests\QuestionCreateRequest;
use Gamify\Http\Requests\QuestionUpdateRequest;
use Gamify\Models\Badge;
use Gamify\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminQuestionController extends AdminController
{
    public function index(): View
    {
        return view('admin.question.index');
    }

    public function create(): View
    {
        return view('admin.question.create');
    }

    public function store(QuestionCreateRequest $request): RedirectResponse
    {
        $question = new Question([
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

            $question->tag($request->tags());

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

    private function addChoicesToQuestion(Question $question, array $choices): void
    {
        if ($question->choices()->count() > 0) {
            $question->choices()->delete();
        }

        if (count($choices) > 0) {
            $question->choices()->createMany($choices);
        }
    }

    public function show(Question $question): View
    {
        return view('admin.question.show')
            ->with('question', $question)
            ->with('relatedBadges', $this->relatedBadgesForQuestion($question));
    }

    private function relatedBadgesForQuestion(Question $question): Collection
    {
        return Badge::triggeredByQuestionsWithTagsIn($question->tagArrayNormalized);
    }

    public function edit(Question $question): View
    {
        return view('admin.question.edit', [
            'question' => $question,
            'selectedTags' => $question->tagArrayNormalized,
            'relatedBadges' => $this->relatedBadgesForQuestion($question),
        ]);
    }

    public function update(QuestionUpdateRequest $request, Question $question): RedirectResponse
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

            $question->retag($request->tags());

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

    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();

        return redirect()->route('admin.questions.index')
            ->with('success', __('admin/question/messages.delete.success'));
    }
}
