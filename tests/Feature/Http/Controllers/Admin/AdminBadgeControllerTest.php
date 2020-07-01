<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Gamify\Badge;
use Gamify\Enums\BadgeActuators;
use Gamify\Http\Middleware\OnlyAjax;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBadgeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function access_is_restricted_to_admins()
    {
        $badge = factory(Badge::class)->create();
        $test_data = [
            ['protocol' => 'GET', 'route' => route('admin.badges.index')],
            ['protocol' => 'GET', 'route' => route('admin.badges.create')],
            ['protocol' => 'POST', 'route' => route('admin.badges.store')],
            ['protocol' => 'GET', 'route' => route('admin.badges.show', $badge)],
            ['protocol' => 'GET', 'route' => route('admin.badges.edit', $badge)],
            ['protocol' => 'PUT', 'route' => route('admin.badges.update', $badge)],
            ['protocol' => 'GET', 'route' => route('admin.badges.delete', $badge)],
            ['protocol' => 'DELETE', 'route' => route('admin.badges.destroy', $badge)],
        ];

        foreach ($test_data as $test) {
            $this->actingAsUser()
                ->call($test['protocol'], $test['route'])
                ->assertForbidden();
        }

        // Ajax routes needs to disable middleware
        $this->actingAsUser()
            ->withoutMiddleware(OnlyAjax::class)
            ->get(route('admin.badges.data'))
            ->assertForbidden();
    }

    /** @test */
    public function index_returns_proper_content()
    {
        $this->actingAsAdmin()
            ->get(route('admin.badges.index'))
            ->assertOK()
            ->assertViewIs('admin.badge.index');
    }

    /** @test */
    public function create_returns_proper_content()
    {
        $this->actingAsAdmin()
            ->get(route('admin.badges.create'))
            ->assertOk()
            ->assertViewIs('admin.badge.create');
    }

    /** @test */
    public function store_creates_an_object()
    {
        $badge = factory(Badge::class)->make();
        $input_data = [
            'name' => $badge->name,
            'description' => $badge->description,
            'required_repetitions' => $badge->required_repetitions,
            'active' => true,
            'actuators' => BadgeActuators::OnQuestionAnswered,
        ];

        $this->actingAsAdmin()
            ->post(route('admin.badges.store'), $input_data)
            ->assertRedirect(route('admin.badges.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function store_returns_errors_on_invalid_data()
    {
        $invalid_input_data = [];

        $this->actingAsAdmin()
            ->post(route('admin.badges.store'), $invalid_input_data)
            ->assertSessionHasErrors()
            ->assertSessionHas('errors');
    }

    /** @test */
    public function show_returns_proper_content()
    {
        $badge = factory(Badge::class)->create();

        $this->actingAsAdmin()
            ->get(route('admin.badges.show', $badge))
            ->assertOk()
            ->assertViewIs('admin.badge.show')
            ->assertSee($badge->name);
    }

    /** @test */
    public function edit_returns_proper_content()
    {
        $badge = factory(Badge::class)->create();

        $this->actingAsAdmin()
            ->get(route('admin.badges.edit', $badge))
            ->assertOk()
            ->assertViewIs('admin.badge.edit')
            ->assertSee($badge->name);
    }

    /** @test */
    public function update_edits_an_object()
    {
        $badge = factory(Badge::class)->create([
            'name' => 'gold',
        ]);
        $input_data = [
            'name' => 'silver',
            'description' => $badge->description,
            'required_repetitions' => $badge->required_repetitions,
            'active' => true,
            'actuators' => $badge->actuators->value,
        ];

        $this->actingAsAdmin()
            ->put(route('admin.badges.update', $badge), $input_data)
            ->assertRedirect(route('admin.badges.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function update_returns_errors_on_invalid_data()
    {
        $badge = factory(Badge::class)->create([
            'name' => 'gold',
        ]);
        $input_data = [
            'name' => 'silver',
        ];

        $this->actingAsAdmin()
            ->put(route('admin.badges.update', $badge), $input_data)
            ->assertSessionHasErrors()
            ->assertSessionHas('errors');
    }

    /** @test */
    public function delete_returns_proper_content()
    {
        $badge = factory(Badge::class)->create();

        $this->actingAsAdmin()
            ->get(route('admin.badges.delete', $badge))
            ->assertOk()
            ->assertViewIs('admin.badge.delete')
            ->assertSee($badge->name);
    }

    /** @test */
    public function destroy_deletes_an_object()
    {
        $badge = factory(Badge::class)->create();

        $this->actingAsAdmin()
            ->delete(route('admin.badges.destroy', $badge))
            ->assertRedirect(route('admin.badges.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function data_returns_proper_content()
    {
        factory(Badge::class, 3)->create();

        $this->actingAsAdmin()
            ->withoutMiddleware(OnlyAjax::class)
            ->get(route('admin.badges.data'))
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function data_fails_for_non_ajax_calls()
    {
        factory(Badge::class, 3)->create();

        $this->actingAsAdmin()
            ->get(route('admin.badges.data'))
            ->assertForbidden();
    }
}
