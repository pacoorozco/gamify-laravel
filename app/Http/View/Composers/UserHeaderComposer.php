<?php

namespace Gamify\Http\View\Composers;

use Gamify\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserHeaderComposer
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
        $user = User::with([
            'profile' => function ($query) {
                $query->select('avatar', 'user_id');
            },
        ])->find(
            $this->user_id,
            ['id', 'name', 'username', 'experience', 'created_at']
        );

        $view->with('user', $user);
    }
}
