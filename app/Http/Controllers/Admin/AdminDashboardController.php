<?php

namespace Gamify\Http\Controllers\Admin;

use Gamify\Badge;
use Gamify\Question;
use Gamify\User;

class AdminDashboardController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data              = [];
        $data['badges']    = Badge::all()->count();
        $data['questions'] = Question::published()->count();
        $data['answers']   = User::Member()->with('answeredQuestions')->count();
        $data['members']   = User::Member()->count();

        return view('admin.dashboard.index', compact('data'));
    }
}
