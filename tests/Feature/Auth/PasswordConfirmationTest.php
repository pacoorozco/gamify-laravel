<?php

namespace Tests\Feature\Auth;

use Gamify\Models\User;
use Tests\Feature\TestCase;

final class PasswordConfirmationTest extends TestCase
{
    public function test_confirm_password_screen_can_be_rendered(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get(route('password.confirm'))
            ->assertSuccessful();
    }

    public function test_password_can_be_confirmed(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'password' => 'Very$3cret',
        ]);

        $this
            ->actingAs($user)
            ->post(route('password.confirm'), [
                'password' => 'Very$3cret',
            ])
            ->assertRedirect()
            ->assertValid();
    }

    public function test_password_is_not_confirmed_with_invalid_password(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'password' => 'Very$3cret',
        ]);

        $this
            ->actingAs($user)
            ->post(route('password.confirm'), [
                'password' => 'wrong-password',
            ])
            ->assertInvalid();
    }
}
