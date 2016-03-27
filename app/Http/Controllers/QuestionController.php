<?php

namespace Gamify\Http\Controllers;

use Gamify\Question;
use Illuminate\Http\Request;

use Gamify\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Auth::user()->getPendingQuestions();
        return view('question.index', compact('questions'));
    }

    /**
     *
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Question $question
     * @return \Illuminate\Http\Response
     */
    public function answer(Request $request, Question $question)
    {
        // TODO: If question has been answered can't answer again

        // TODO: Validate

        // TODO: AI. Global Badges

        // AI. Obtain how many points has its answer obtained
        $points = 0;
        $success = false;

        foreach ($request->choices as $answer) {
            $choice = $question->choices()->find($answer);
            $points += $choice->points;
            $success = $success || $choice->correct;
        }
        // minimun points for answer is '1'
        if ($points < 1) {
            $points = 1;
        }

        // AI. Add XP to user
        Game::addExperience(Auth::user(), $points, 'has earned ' . $points . ' points.');

        // AI. Specific Badges
        if ($success) {
            $answerStatus = 'correct';
        } else {
            $answerStatus = 'incorrect';
        }
        $badges = $question->actions()
            ->whereIn('when', ['always', $answerStatus]);

        // AI. Increment actions
        foreach ($badges as $badge) {
            Game::incrementBadge(Auth::user(), $badge);
        }

        // AI. Add notifications and return view
        return $this->show($question);
    }

    /**
     * Display the specified resource.
     *
     * @param  Question $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        // TODO: If question has been answered, not show form

        return view('question.show', compact('question'));
    }
}
