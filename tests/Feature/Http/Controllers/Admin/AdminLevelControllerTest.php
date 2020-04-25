<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Gamify\Badge;
use Gamify\Http\Middleware\OnlyAjax;
use Gamify\Level;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLevelControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function access_is_restricted_to_admins()
    {
        $level = factory(Level::class)->create();
        $test_data = [
            ['protocol' => 'GET', 'route' => route('admin.levels.index')],
            ['protocol' => 'GET', 'route' => route('admin.levels.create')],
            ['protocol' => 'POST', 'route' => route('admin.levels.store')],
            ['protocol' => 'GET', 'route' => route('admin.levels.show', $level)],
            ['protocol' => 'GET', 'route' => route('admin.levels.edit', $level)],
            ['protocol' => 'PUT', 'route' => route('admin.levels.update', $level)],
            ['protocol' => 'GET', 'route' => route('admin.levels.delete', $level)],
            ['protocol' => 'DELETE', 'route' => route('admin.levels.destroy', $level)]
        ];

        foreach ($test_data as $test) {
            $this->actingAsUser()
                ->call($test['protocol'], $test['route'])
                ->assertForbidden();
        }

        // Ajax routes needs to disable middleware
        $this->actingAsUser()
            ->withoutMiddleware(OnlyAjax::class)
            ->get(route('admin.levels.data'))
            ->assertForbidden();

    }

    /** @test */
    public function index_returns_proper_content()
    {
        $this->actingAsAdmin()
            ->get(route('admin.levels.index'))
            ->assertOK()
            ->assertViewIs('admin.level.index');
    }

    /** @test */
    public function create_returns_proper_content()
    {
        $this->actingAsAdmin()
            ->get(route('admin.levels.create'))
            ->assertOk()
            ->assertViewIs('admin.level.create');
    }

    /** @test */
    public function store_creates_an_object()
    {
        $level = factory(Level::class)->make();
        $input_data = [
            'name' => $level->name,
            'required_points' => $level->required_points,
            'active' => true,
        ];

        $this->actingAsAdmin()
            ->post(route('admin.levels.store'), $input_data)
            ->assertRedirect(route('admin.levels.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function store_returns_errors_on_invalid_data()
    {
        $invalid_input_data = [];

        $this->actingAsAdmin()
            ->post(route('admin.levels.store'), $invalid_input_data)
            ->assertSessionHasErrors()
            ->assertSessionHas('errors');
    }

    /** @test */
    public function show_returns_proper_content()
    {
        $level = factory(Level::class)->create();

        $this->actingAsAdmin()
            ->get(route('admin.levels.show', $level))
            ->assertOk()
            ->assertViewIs('admin.level.show')
            ->assertSee($level->name);
    }

    /** @test */
    public function edit_returns_proper_content()
    {
        $level = factory(Level::class)->create();

        $this->actingAsAdmin()
            ->get(route('admin.levels.edit', $level))
            ->assertOk()
            ->assertViewIs('admin.level.edit')
            ->assertSee($level->name);
    }

    /** @test */
    public function update_edits_an_object()
    {
        $level = factory(Level::class)->create([
            'name' => 'Level gold',
        ]);
        $input_data = [
            'name' => 'Level silver',
            'required_points' => $level->required_points,
            'active' => true,
        ];

        $this->actingAsAdmin()
            ->put(route('admin.levels.update', $level), $input_data)
            ->assertRedirect(route('admin.levels.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function update_returns_errors_on_invalid_data()
    {
        $level = factory(Level::class)->create([
            'name' => 'Level gold',
        ]);
        $input_data = [
            'name' => '',
        ];

        $this->actingAsAdmin()
            ->put(route('admin.levels.update', $level), $input_data)
            ->assertSessionHasErrors()
            ->assertSessionHas('errors');
    }

    /** @test */
    public function delete_returns_proper_content()
    {
        $level = factory(Level::class)->create();

        $this->actingAsAdmin()
            ->get(route('admin.levels.delete', $level))
            ->assertOk()
            ->assertViewIs('admin.level.delete')
            ->assertSee($level->name);
    }

    /** @test */
    public function destroy_deletes_an_object()
    {
        $level = factory(Level::class)->create();

        $this->actingAsAdmin()
            ->delete(route('admin.levels.destroy', $level))
            ->assertRedirect(route('admin.levels.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function data_returns_proper_content()
    {
        factory(Level::class, 2)->create();

        $this->actingAsAdmin()
            ->withoutMiddleware(OnlyAjax::class)
            ->get(route('admin.levels.data'))
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function data_fails_for_non_ajax_calls()
    {
        factory(Level::class, 3)->create();

        $this->actingAsAdmin()
            ->get(route('admin.levels.data'))
            ->assertForbidden();
    }
}
