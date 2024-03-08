<?php

namespace Tests\Feature\Auth;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Gamify\Models\User;
use Gamify\Providers\RouteServiceProvider;
use Generator;
use Tests\Feature\TestCase;

final class RegistrationTest extends TestCase
{
    public function test_registration_screen_can_be_rendered(): void
    {
        $this
            ->get(route('register'))
            ->assertSuccessful();
    }

    public function test_new_users_can_register(): void
    {
        $this->post(route('register'), [
            'username' => 'test.user',
            'email' => 'test@example.com',
            'password' => 'Very$3cret',
            'password_confirmation' => 'Very$3cret',
            'terms' => true,
        ])
            ->assertRedirect(RouteServiceProvider::HOME);

        $this->assertAuthenticated();
    }

    #[Test]
    #[DataProvider('provideWrongDataForUserRegistration')]
    public function it_should_get_errors_when_registering_with_wrong_data(
        array $data,
        array $errors
    ): void {
        // User to validate unique rules...
        User::factory()->create([
            'username' => 'john',
            'email' => 'john.doe@domain.local',
        ]);

        /** @var User $want */
        $want = User::factory()->make();

        $formData = [
            'username' => $data['username'] ?? $want->username,
            'email' => $data['email'] ?? $want->email,
            'password' => $data['password'] ?? $want->password,
            'password_confirmation' => $data['password_confirmation'] ?? $want->password,
            'terms' => $data['terms'] ?? true,
        ];

        $this->post(route('register'), $formData)
            ->assertInvalid($errors);

        $this->assertGuest();
    }

    public static function provideWrongDataForUserRegistration(): Generator
    {
        yield 'username is empty' => [
            'data' => [
                'username' => '',
            ],
            'errors' => ['username'],
        ];

        yield 'username > 255 chars' => [
            'data' => [
                'username' => '01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012
34567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345',
            ],
            'errors' => ['username'],
        ];

        yield 'username ! a username' => [
            'data' => [
                'username' => 'u$ern4me',
            ],
            'errors' => ['username'],
        ];

        yield 'username is taken' => [
            'data' => [
                'username' => 'john',
            ],
            'errors' => ['username'],
        ];

        yield 'email is empty' => [
            'data' => [
                'email' => '',
            ],
            'errors' => ['email'],
        ];

        yield 'email ! an email' => [
            'data' => [
                'email' => 'is-not-an-email',
            ],
            'errors' => ['email'],
        ];

        yield 'email is taken' => [
            'data' => [
                'email' => 'john.doe@domain.local',
            ],
            'errors' => ['email'],
        ];

        yield 'password is empty' => [
            'data' => [
                'password' => '',
            ],
            'errors' => ['password'],
        ];

        yield 'password ! complex enough' => [
            'data' => [
                'password' => '1234',
            ],
            'errors' => ['password'],
        ];

        yield 'password ! confirmed' => [
            'data' => [
                'password' => 'verySecretPassword',
                'password_confirmation' => 'notSoSecretPassword',
            ],
            'errors' => ['password'],
        ];

        yield 'terms is empty' => [
            'data' => [
                'terms' => '',
            ],
            'errors' => ['terms'],
        ];

        yield 'terms is not checked' => [
            'data' => [
                'terms' => false,
            ],
            'errors' => ['terms'],
        ];
    }
}
