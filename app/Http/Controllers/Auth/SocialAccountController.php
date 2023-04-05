<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Some rights reserved. See LICENSE and AUTHORS files.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

namespace Gamify\Http\Controllers\Auth;

use Gamify\Events\SocialLogin;
use Gamify\Http\Controllers\Controller;
use Gamify\Providers\RouteServiceProvider;
use Gamify\Services\SocialAccountService;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class SocialAccountController extends Controller
{
    /**
     * Redirect the user to the Provider authentication page.
     */
    public function redirectToProvider(string $provider): \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information.
     */
    public function handleProviderCallback(SocialAccountService $accountRepository, string $provider): RedirectResponse
    {
        $externalUser = Socialite::driver($provider)->user();

        $user = $accountRepository->findOrCreate($externalUser, $provider);

        auth()->login($user, false);

        SocialLogin::dispatch($user);

        return redirect()->to(RouteServiceProvider::HOME);
    }
}
