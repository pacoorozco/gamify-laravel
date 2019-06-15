<?php

namespace Gamify\Http\Controllers;

use Gamify\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @param \Illuminate\Http\Request $request
     * @param Question                 $question
     *
     * @return \Illuminate\Http\Response
     */
    public function answer(Request $request, Question $question)
    {
        // TODO: If question has been answered can't answer again

        // TODO: Validate

        // TODO: AI. Global Badges

        // Obtain how many points has its answer obtained
        $points = 0;
        $success = false;

        foreach ($request->choices as $answer) {
            $choice = $question->choices()->find($answer);
            $points += $choice->score;
            $success = $success || $choice->correct;
        }
        // minimun points for answer is '1'
        if ($points < 1) {
            $points = 1;
        }

        // Create relation between User and Question
        Auth::user()->answeredQuestions()->attach($question, [
            'points'  => $points,
            'answers' => implode(',', $request->choices),
        ]);

        // Add XP to user
        Game::addExperience(Auth::user(), $points, 'has earned '.$points.' points.');

        // Deal with Question specific Badges
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
        return redirect()->route('questions.show', $question->short_name);
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        // TODO: If question has been answered, not show form
        if ($answer = Auth::user()->answeredQuestions()->find($question->id)) {
            // User has answered this question
            return view('question.show-answered', compact('answer', 'question'));
        }

        return view('question.show', compact('question'));
    }
}
