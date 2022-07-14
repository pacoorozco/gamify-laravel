<?php

namespace Gamify\Http\Controllers\Auth;

use Gamify\Http\Controllers\Controller;
use Gamify\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request): View|RedirectResponse
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(RouteServiceProvider::HOME)
                    : view('auth.verify-email');
    }
}
