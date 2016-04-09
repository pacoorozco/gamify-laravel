<?php

namespace Gamify\Http\Controllers;

use Illuminate\Support\Facades\Auth;

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
        $questions = $user->getPendingQuestions()->take(3);
        $usersInRanking = Game::getRanking();

        return view('dashboard.index', compact('user', 'questions', 'usersInRanking'));
    }
}
