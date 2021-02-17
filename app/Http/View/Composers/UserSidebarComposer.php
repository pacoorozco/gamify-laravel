<?php

namespace Gamify\Http\View\Composers;

use Gamify\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserSidebarComposer
{
    /** @var int */
    private $user_id;

    /**
     * Create a new User Dropdown composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user_id = Auth::id();
    }

    /**
     * Bind data to the view.
     *
     * @param \Illuminate\View\View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $user = User::findOrFail(
            $this->user_id,
            ['id']
        );

        $questions = $user->pendingQuestions();
        $questions_count = $questions->count();

        $view->with('questions_count', $questions_count);
    }
}
