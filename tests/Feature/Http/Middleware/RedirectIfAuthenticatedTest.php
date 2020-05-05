<?php

namespace Tests\Feature\Http\Middleware;

use Gamify\Http\Middleware\RedirectIfAuthenticated;
use Gamify\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RedirectIfAuthenticatedTest extends TestCase
{
    use RefreshDatabase;

    const TEST_ENDPOINT = '/_test/only_for_guests';

    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware(RedirectIfAuthenticated::class)->get(self::TEST_ENDPOINT, function () {
            return 'Access granted for non authenticated users';
        });
    }

    /** @test */
    public function it_response_ok_for_non_authenticated_users()
    {
        $response = $this->get(self::TEST_ENDPOINT);

        $response->assertOk();
        $response->assertSee('Access granted for non authenticated users');
    }

    /** @test */
    public function it_redirects_to_home_for_authenticated_users_requests()
    {
        $response = $this->actingAsUser()
            ->get(self::TEST_ENDPOINT);

        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
