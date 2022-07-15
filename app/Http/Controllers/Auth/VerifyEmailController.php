<?php

namespace Gamify\Http\Controllers\Auth;

use Gamify\Http\Controllers\Controller;
use Gamify\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        /** @phpstan-ignore-next-line */
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
        }

        /** @phpstan-ignore-next-line */
        if ($request->user()->markEmailAsVerified()) {
            /** @phpstan-ignore-next-line */
            event(new Verified($request->user()));
        }

        return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
    }
}
