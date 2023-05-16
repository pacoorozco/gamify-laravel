<?php

namespace Gamify\Http\Controllers\Auth;

use Gamify\Actions\RegisterUserAction;
use Gamify\Http\Controllers\Controller;
use Gamify\Http\Requests\UserRegistrationRequest;
use Gamify\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(UserRegistrationRequest $request, RegisterUserAction $registerUserAction): RedirectResponse
    {
        $user = $registerUserAction->execute(
            username: $request->username(),
            email: $request->email(),
            password: $request->password(),
        );

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
