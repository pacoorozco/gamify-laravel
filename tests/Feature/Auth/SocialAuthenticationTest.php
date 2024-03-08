<?php

namespace Tests\Feature\Auth;

use PHPUnit\Framework\Attributes\Test;
use Gamify\Events\SocialLogin;
use Gamify\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Event;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\Feature\TestCase;

final class SocialAuthenticationTest extends TestCase
{
    #[Test]
    public function it_should_authenticate_users_using_social_login(): void
    {
        $this->mockSocialLogin();

        Event::fake(SocialLogin::class);

        $this
            ->get(route('social.callback', 'okta'))
            ->assertRedirect(RouteServiceProvider::HOME);

        Event::assertDispatched(SocialLogin::class);

        $this->assertAuthenticated();
    }

    protected function mockSocialLogin(): void
    {
        $abstractUser = Mockery::mock(\Laravel\Socialite\Two\User::class);
        /* @phpstan-ignore-next-line */
        $abstractUser
            ->shouldReceive('getId')
            ->andReturn('u-123456')
            ->shouldReceive('getName')
            ->andReturn('fooName')
            ->shouldReceive('getNickname')
            ->andReturn('fooUsername')
            ->shouldReceive('getEmail')
            ->andReturn('foo@domain.com');

        $mockedProvider = Mockery::mock(\Laravel\Socialite\Contracts\Provider::class);
        /* @phpstan-ignore-next-line */
        $mockedProvider
            ->shouldReceive('user')
            ->andReturn($abstractUser);

        Socialite::shouldReceive('driver')
            ->with('okta')
            ->andReturn($mockedProvider)
            ->once();
    }
}
