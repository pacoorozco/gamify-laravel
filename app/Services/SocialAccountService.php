<?php

namespace Gamify\Services;

use Gamify\LinkedSocialAccount;
use Gamify\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    /**
     * Returns the User object authenticated by a social login.
     * If the user didn't exist, it will be created.
     *
     * @param \Laravel\Socialite\Contracts\User $providerUser
     * @param string                            $provider
     *
     * @return \Gamify\User
     */
    public function findOrCreate(ProviderUser $providerUser, string $provider)
    {
        $account = LinkedSocialAccount::where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        }

        $user = User::where('email', $providerUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'email' => $providerUser->getEmail(),
                'name' => $providerUser->getName(),
                'username' => $this->generateUsernameFromEmail($providerUser->getEmail()),
            ]);
            
            $user->profile()->create();
        }

        $user->accounts()->create([
            'provider_id' => $providerUser->getId(),
            'provider_name' => $provider,
        ]);

        return $user;
    }

    /**
     * Returns an unique username from the given email.
     *
     * @param string $email
     *
     * @return string
     */
    private function generateUsernameFromEmail(string $email): string
    {
        $username = Str::before($email, '@');
        $uniqueUsername = $username;
        while (User::where('username', $uniqueUsername)->first(['id'])) {
            $uniqueUsername = $username . Str::random(2);
        }
        return $uniqueUsername;
    }
}
