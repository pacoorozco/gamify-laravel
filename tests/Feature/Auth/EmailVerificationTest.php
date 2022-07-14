<?php

namespace Tests\Feature\Auth;

use Gamify\Models\User;
use Gamify\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this
            ->actingAs($user)
            ->get(route('verification.notice'))
            ->assertSuccessful();
    }

    public function test_email_can_be_verified(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this
            ->actingAs($user)
            ->get($verificationUrl)
            ->assertRedirect(RouteServiceProvider::HOME . '?verified=1');

        $this->assertTrue($user->fresh()->hasVerifiedEmail());

        Event::assertDispatched(Verified::class);
    }

    public function test_email_is_not_verified_with_invalid_hash(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong-email')]
        );

        $this
            ->actingAs($user)
            ->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }
}
