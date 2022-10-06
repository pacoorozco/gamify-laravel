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

use Gamify\Events\QuestionAnswered;
use Gamify\Http\Requests\QuestionAnswerRequest;
use Gamify\Models\Question;
use Gamify\Models\QuestionChoice;
use Gamify\Models\User;
use Gamify\Models\UserResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(): View
    {
        /** @var User $user */
        $user = User::findOrFail(Auth::id());

        $questionsCount = Question::published()->count();
        $questionsCompletion = ($questionsCount > 0)
            ? round(($user->answeredQuestionsCount() / $questionsCount) * 100)
            : 0;

        return view('question.index', [
            'questions' => $user->pendingQuestions(),
            'next_level_name' => $user->nextLevel()->name,
            'points_to_next_level' => $user->pointsToNextLevel(),
            'percentage_to_next_level' => $user->nextLevelCompletion(),
            'answered_questions' => $user->answeredQuestionsCount(),
            'percentage_of_answered_questions' => $questionsCompletion,
        ]);
    }

    public function answer(QuestionAnswerRequest $request, Question $question): View
    {
        /** @var User $user */
        $user = User::findOrFail(Auth::id());

        abort_if($user->hasAnsweredQuestion($question), 404);

        abort_unless($question->isPublished() || $user->isAdmin(), 404);

        // Obtain how many points has its answer obtained
        $points = 0;
        $answerCorrectness = false;

        foreach ($request->choices as $answer) {
            /** @var QuestionChoice $choice */
            $choice = $question->choices()->find($answer);
            $points += $choice->score;
            $answerCorrectness = $answerCorrectness || $choice->isCorrect();
        }
        // minimum points for answer is '1'
        if ($points < 1) {
            $points = 1;
        }

        $user->answeredQuestions()->attach($question,
            UserResponse::asArray(
                score: $points,
                choices: $request->choices,
            )
        );

        // Trigger an event that will update XP, badges...
        QuestionAnswered::dispatch($user, $question, $points, $answerCorrectness);

        return view('question.show')
            ->with('question', $question)
            ->with('response', $user->getResponseForQuestion($question));
    }

    public function show(Question $question): View
    {
        /** @var User $user */
        $user = User::findOrFail(Auth::id());

        abort_unless($question->isPublished() || $user->isAdmin(), 404);

        $response = $user->getResponseForQuestion($question);

        return view('question.show')
            ->with('question', $question)
            ->with('response', $response);
    }
}
