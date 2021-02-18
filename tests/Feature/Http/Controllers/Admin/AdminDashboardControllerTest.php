<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Gamify\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        /** @var User $admin */
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);
    }

    /** @test */
    public function access_is_restricted_to_admins()
    {
        $test_data = [
            ['protocol' => 'GET', 'route' => route('admin.home')],
        ];

        /** @var User $user */
        $user = User::factory()->create();

        foreach ($test_data as $test) {
            $this->actingAs($user)
                ->call($test['protocol'], $test['route'])
                ->assertForbidden();
        }
    }

    /** @test */
    public function index_returns_proper_content()
    {
        $this->get(route('admin.home'))
            ->assertOK()
            ->assertViewIs('admin.dashboard.index')
            ->assertViewHasAll([
                'members_count',
                'questions_count',
                'badges_count',
                'levels_count',
                'latest_questions',
                'latest_users',
            ]);
    }
}
