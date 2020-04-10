<?php

namespace Gamify\Http\Controllers;

use Gamify\Http\Requests\UserProfileUpdateRequest;
use Gamify\User;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        $questions_count = $user->pendingQuestions()->count();

        return view('profile.show', compact('user', 'questions_count'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserProfileUpdateRequest $request
     * @param User                     $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserProfileUpdateRequest $request, User $user)
    {
        $user->profile->fill($request->all())->save();

        return redirect()->route('profiles.show', $user->username)
            ->with('success', __('user/messages.settings_updated'));
    }
}
