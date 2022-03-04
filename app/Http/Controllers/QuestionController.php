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
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(): View
    {
        $user = User::findOrFail(Auth::id());
        $questions = $user->pendingQuestions();

        // If the user is in the highest level, some hacks needs to be done.
        try {
            $next_level = $user->getNextLevel();
            $next_level_name = $next_level->name;
            $diff_between_levels = $next_level->required_points - $user->experience;
            $points_to_next_level = ($diff_between_levels > 0) ? $diff_between_levels : 0;
            $percentage_to_next_level = ($points_to_next_level > 0)
                ? round(($diff_between_levels / $next_level->required_points) * 100)
                : 100;
        } catch (\Exception $exception) {
            $next_level_name = $user->level;
            $points_to_next_level = 0;
            $percentage_to_next_level = 100;
        }

        // Questions
        $number_of_questions = Question::published()->count();
        $answered_questions = $user->answeredQuestions()->count();
        $percentage_of_answered_questions = ($number_of_questions > 0)
            ? round(($answered_questions / $number_of_questions) * 100)
            : 0;

        return view('question.index', [
            'questions' => $questions,
            'next_level_name' => $next_level_name,
            'points_to_next_level' => $points_to_next_level,
            'percentage_to_next_level' => $percentage_to_next_level,
            'answered_questions' => $answered_questions,
            'percentage_of_answered_questions' => $percentage_of_answered_questions,
        ]);
    }

    public function answer(QuestionAnswerRequest $request, Question $question): View
    {
        // TODO: If question has been answered can't answer again

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

        // Create relation between User and Question
        /** @var User $user */
        $user = User::findOrFail($request->user()->id);
        $user->answeredQuestions()->attach($question, [
            'points' => $points,
            'answers' => implode(',', $request->choices),
        ]);

        // Trigger an event that will update XP, badges...
        event(new QuestionAnswered($user, $question, $points, $answerCorrectness));

        // AI. Add notifications and return view
        return view('question.show-answered', [
            'answer' => $user->answeredQuestions()->find($question->id),
            'question' => $question,
        ]);
    }

    public function show(Question $question): View
    {
        // TODO: If question has been answered, not show form
        $user = User::findOrFail(Auth::id());
        if ($answer = $user->answeredQuestions()->find($question->id)) {
            // User has answered this question
            return view('question.show-answered', [
                'answer' => $answer,
                'question' => $question,
            ]);
        }

        return view('question.show', compact('question'));
    }
}
