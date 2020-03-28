<?php

namespace Gamify\Http\Controllers\Auth;

use Gamify\Http\Controllers\Controller;
use Gamify\Providers\RouteServiceProvider;
use Gamify\Services\SocialAccountService;
use Laravel\Socialite\Facades\Socialite;

class SocialAccountController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @param string $provider - Provider name to use.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information.
     *
     * @param \Gamify\Services\SocialAccountService $accountRepository
     * @param string                                $provider
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback(SocialAccountService $accountRepository, string $provider)
    {
        try {
            $user = Socialite::with($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login');
        }

        $authUser = $accountRepository->findOrCreate(
            $user,
            $provider
        );

        auth()->login($authUser, true);

        return redirect()->to(RouteServiceProvider::HOME);
    }
}
