<?php

namespace Tests\Browser;

use Gamify\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testIsLoginPage()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                ->assertTitle('Login :: gamify v3')
                ->assertSee('I forgot my password');
        });
    }

    public function testFailedLogin()
    {
        $user = factory(User::class)->create([
            'email' => 'test@example.com',
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('@login-email-input', $user->email)
                ->type('@login-password-input', 'not_secret')
                ->click('@login-button')
                ->assertPathIs('/login')
                ->assertSee('These credentials do not match our records');
        });
    }

    public function testSuccessfulLogin()
    {
        $user = factory(User::class)->create([
            'email' => 'test@example.com',
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('@login-email-input', $user->email)
                ->type('@login-password-input', 'secret')
                ->click('@login-button')
                ->assertPathIs('/')
                ->assertAuthenticatedAs($user);
        });
    }
}
