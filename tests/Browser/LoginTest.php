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

    public function testSuccessfulLogin()
    {
        $user = factory(User::class)->create([
            'email' => 'test@example.com',
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->click('loginButton')
                ->assertPathIs('/home')
                ->assertAuthenticatedAs($user);
        });
    }
}
