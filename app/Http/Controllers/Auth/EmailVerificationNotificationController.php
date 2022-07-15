<?php

namespace Gamify\Http\Controllers\Auth;

use Gamify\Http\Controllers\Controller;
use Gamify\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /** @phpstan-ignore-next-line */
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        /** @phpstan-ignore-next-line */
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'verification-link-sent');
    }
}
