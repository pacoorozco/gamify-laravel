<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_returns_proper_content()
    {
        $this->actingAsUser()
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
