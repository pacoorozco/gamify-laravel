<?php

namespace Tests\Feature\Http\Controllers;

use Gamify\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_returns_proper_content()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('home'))
            ->assertOK()
            ->assertViewIs('dashboard.index')
            ->assertViewHasAll([
                'questions',
                'questions_count',
                'usersInRanking',
            ]);
    }
}
