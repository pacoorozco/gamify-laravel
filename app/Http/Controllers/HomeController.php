<?php

namespace Gamify\Http\Controllers;

use Gamify\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Gamify\Question;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // TODO: Add an scope to only index questions (published and not answered and not hidden)
        $answeredQuestions = Auth::user()->answeredQuestions()->lists('question_id')->toArray();
        $questions = Question::whereNotIn('id', $answeredQuestions)->get();

        return view('dashboard.index', compact('user', 'questions'));
    }

}
