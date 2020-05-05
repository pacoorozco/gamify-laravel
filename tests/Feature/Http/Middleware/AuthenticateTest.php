<?php

namespace Tests\Feature\Http\Middleware;

use Gamify\Http\Middleware\Authenticate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{
    use RefreshDatabase;

    const TEST_ENDPOINT = '/_test/only_for_authenticated';

    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware(Authenticate::class)->get(self::TEST_ENDPOINT, function () {
            return 'Access granted for authenticated users';
        });
    }

    /** @test */
    public function it_response_ok_for_authenticated_users()
    {
        $response = $this->actingAsUser()
            ->get(self::TEST_ENDPOINT);

        $response->assertOk();
        $response->assertSee('Access granted for authenticated users');
    }

    /** @test */
    public function it_redirects_to_login_for_non_authenticated_users()
    {
        $response = $this->get(self::TEST_ENDPOINT);

        $response->assertRedirect(route('login'));
    }
}
