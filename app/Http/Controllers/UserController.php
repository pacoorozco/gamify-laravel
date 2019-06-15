<?php

namespace Gamify\Http\Controllers;

use Gamify\User;
use Gamify\Http\Requests\UserProfileUpdateRequest;

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
        return view('profile.show', compact('user'));
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
            ->with('success', trans('user/messages.settings_updated'));
    }
}
