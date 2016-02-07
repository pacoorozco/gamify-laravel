<?php

namespace Gamify\Http\Controllers;

use Gamify\Question;
use Illuminate\Http\Request;

use Gamify\Http\Requests;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO: Add an scope to only index questions (published and not answered and not hidden)
        $questions = Question::all();

        return view('question.index', compact('questions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Question $question
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Question $question)
    {
        // TODO: If question has been answered can't answer again

        // 1. Answer question, obtain how many xp will add
        // 2. Add XP to user
        // 3. Obtain any related question action
        // 4. Increment actions
        // 5. Add notifications and return view
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
