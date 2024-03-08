<?php

namespace Tests\Feature\Auth;

use Gamify\Models\User;
use Gamify\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Tests\Feature\TestCase;

final class AuthenticationTest extends TestCase
{
    public function test_login_screen_can_be_rendered(): void
    {
        $this
            ->get(route('login'))
            ->assertSuccessful();
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'password' => 'Very$3cret',
        ]);

        Event::fake();

        $this
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'Very$3cret',
            ])
            ->assertRedirect(RouteServiceProvider::HOME);

        Event::assertDispatched(Login::class);

        $this->assertAuthenticated();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'password' => 'Very$3cret',
        ]);

        Event::fake();

        $this
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);

        Event::assertNotDispatched(Login::class);

        $this->assertGuest();
    }
}
