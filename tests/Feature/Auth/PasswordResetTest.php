<?php

namespace Tests\Feature\Auth;

use Gamify\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Tests\Feature\TestCase;

final class PasswordResetTest extends TestCase
{
    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $this
            ->get(route('password.request'))
            ->assertSuccessful();
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        Notification::fake();

        /** @var User $user */
        $user = User::factory()->create();

        $this
            ->post(route('password.email'), ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        Notification::fake();

        /** @var User $user */
        $user = User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
            $this
                ->get(route('password.reset', $notification->token))
                ->assertSuccessful();

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        Notification::fake();

        /** @var User $user */
        $user = User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $this
                ->post(route('password.update'), [
                    'token' => $notification->token,
                    'email' => $user->email,
                    'password' => 'Very$3cret',
                    'password_confirmation' => 'Very$3cret',
                ])
                ->assertValid();

            return true;
        });
    }
}
