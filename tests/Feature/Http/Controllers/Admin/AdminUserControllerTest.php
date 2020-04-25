<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Gamify\Http\Middleware\OnlyAjax;
use Gamify\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function access_is_restricted_to_admins()
    {
        $user = factory(User::class)->create();
        $test_data = [
            ['protocol' => 'GET', 'route' => route('admin.users.index')],
            ['protocol' => 'GET', 'route' => route('admin.users.create')],
            ['protocol' => 'POST', 'route' => route('admin.users.store')],
            ['protocol' => 'GET', 'route' => route('admin.users.show', $user)],
            ['protocol' => 'GET', 'route' => route('admin.users.edit', $user)],
            ['protocol' => 'PUT', 'route' => route('admin.users.update', $user)],
            ['protocol' => 'GET', 'route' => route('admin.users.delete', $user)],
            ['protocol' => 'DELETE', 'route' => route('admin.users.destroy', $user)]
        ];

        foreach ($test_data as $test) {
            $this->actingAsUser()
                ->call($test['protocol'], $test['route'])
                ->assertForbidden();
        }

        // Ajax routes needs to disable middleware
        $this->actingAsUser()
            ->withoutMiddleware(OnlyAjax::class)
            ->get(route('admin.users.data'))
            ->assertForbidden();

    }

    /** @test */
    public function index_returns_proper_content()
    {
        $this->actingAsAdmin()
            ->get(route('admin.users.index'))
            ->assertOK()
            ->assertViewIs('admin.user.index');
    }

    /** @test */
    public function create_returns_proper_content()
    {
        $this->actingAsAdmin()
            ->get(route('admin.users.create'))
            ->assertOk()
            ->assertViewIs('admin.user.create');
    }

    /** @test */
    public function store_creates_an_object()
    {
        $user = factory(User::class)->make();
        $input_data = [
            'username' => $user->username,
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'very_secret',
            'password_confirmation' => 'very_secret',
            'role' => $user->role,
        ];

        $this->actingAsAdmin()
            ->post(route('admin.users.store'), $input_data)
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function store_returns_errors_on_invalid_data()
    {
        $invalid_input_data = [
            'username' => 'yoda',
        ];

        $this->actingAsAdmin()
            ->post(route('admin.users.store'), $invalid_input_data)
            ->assertSessionHasErrors()
            ->assertSessionHas('errors');
    }

    /** @test */
    public function show_returns_proper_content()
    {
        $user = factory(User::class)->create();

        $this->actingAsAdmin()
            ->get(route('admin.users.show', $user))
            ->assertOk()
            ->assertViewIs('admin.user.show')
            ->assertSee($user->username);
    }

    /** @test */
    public function edit_returns_proper_content()
    {
        $user = factory(User::class)->create();

        $this->actingAsAdmin()
            ->get(route('admin.users.edit', $user))
            ->assertOk()
            ->assertViewIs('admin.user.edit')
            ->assertSee($user->name);
    }

    /** @test */
    public function update_edits_an_object()
    {
        $user = factory(User::class)->create([
            'name' => 'Han Solo',
        ]);
        $input_data = [
            'name' => 'Leia',
            'email' => $user->email,
            'role' => $user->role,
        ];

        $this->actingAsAdmin()
            ->put(route('admin.users.update', $user), $input_data)
            ->assertRedirect(route('admin.users.edit', $user))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function update_returns_errors_on_invalid_data()
    {
        $user = factory(User::class)->create([
            'username' => 'anakin',
        ]);
        $input_data = [
            'username' => '',
        ];

        $this->actingAsAdmin()
            ->put(route('admin.users.update', $user), $input_data)
            ->assertSessionHasErrors()
            ->assertSessionHas('errors');
    }

    /** @test */
    public function delete_returns_proper_content()
    {
        $user = factory(User::class)->create();

        $this->actingAsAdmin()
            ->get(route('admin.users.delete', $user))
            ->assertOk()
            ->assertViewIs('admin.user.delete')
            ->assertSee($user->name);
    }

    /** @test */
    public function destroy_deletes_an_object()
    {
        $user = factory(User::class)->create();

        $this->actingAsAdmin()
            ->delete(route('admin.users.destroy', $user))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function data_returns_proper_content()
    {
        // Two users has already been created by TestCase.
        factory(User::class, 3)->create();

        $this->actingAsAdmin()
            ->withoutMiddleware(OnlyAjax::class)
            ->get(route('admin.users.data'))
            ->assertJsonCount(5, 'data');

    }

    /** @test */
    public function data_fails_for_non_ajax_calls()
    {
        // Two users has already been created by TestCase.
        factory(User::class, 3)->create();

        $this->actingAsAdmin()
            ->get(route('admin.users.data'))
            ->assertForbidden();
    }
}
