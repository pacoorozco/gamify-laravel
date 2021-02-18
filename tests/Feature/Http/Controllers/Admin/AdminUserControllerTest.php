<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Gamify\Http\Middleware\OnlyAjax;
use Gamify\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserControllerTest extends TestCase
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
        $user = User::factory()->create();
        $test_data = [
            ['protocol' => 'GET', 'route' => route('admin.users.index')],
            ['protocol' => 'GET', 'route' => route('admin.users.create')],
            ['protocol' => 'POST', 'route' => route('admin.users.store')],
            ['protocol' => 'GET', 'route' => route('admin.users.show', $user)],
            ['protocol' => 'GET', 'route' => route('admin.users.edit', $user)],
            ['protocol' => 'PUT', 'route' => route('admin.users.update', $user)],
            ['protocol' => 'GET', 'route' => route('admin.users.delete', $user)],
            ['protocol' => 'DELETE', 'route' => route('admin.users.destroy', $user)],
        ];

        /** @var User $user */
        $user = User::factory()->create();

        foreach ($test_data as $test) {
            $this->actingAs($user)
                ->call($test['protocol'], $test['route'])
                ->assertForbidden();
        }

        // Ajax routes needs to disable middleware
        $this->actingAs($user)
            ->withoutMiddleware(OnlyAjax::class)
            ->get(route('admin.users.data'))
            ->assertForbidden();
    }

    /** @test */
    public function index_returns_proper_content()
    {
        $this->get(route('admin.users.index'))
            ->assertOK()
            ->assertViewIs('admin.user.index');
    }

    /** @test */
    public function create_returns_proper_content()
    {
        $this->get(route('admin.users.create'))
            ->assertOk()
            ->assertViewIs('admin.user.create');
    }

    /** @test */
    public function store_creates_an_object()
    {
        /** @var User $user */
        $user = User::factory()->make();
        $input_data = [
            'username' => $user->username,
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'very_secret',
            'password_confirmation' => 'very_secret',
            'role' => $user->role,
        ];

        $this->post(route('admin.users.store'), $input_data)
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

        $this->post(route('admin.users.store'), $invalid_input_data)
            ->assertSessionHasErrors()
            ->assertSessionHas('errors');
    }

    /** @test */
    public function show_returns_proper_content()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->get(route('admin.users.show', $user))
            ->assertOk()
            ->assertViewIs('admin.user.show')
            ->assertSee($user->username);
    }

    /** @test */
    public function edit_returns_proper_content()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->get(route('admin.users.edit', $user))
            ->assertOk()
            ->assertViewIs('admin.user.edit')
            ->assertSee($user->name);
    }

    /** @test */
    public function update_edits_an_object()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'Han Solo',
        ]);
        $input_data = [
            'name' => 'Leia',
            'email' => $user->email,
            'role' => $user->role,
        ];

        $this->put(route('admin.users.update', $user), $input_data)
            ->assertRedirect(route('admin.users.edit', $user))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function update_returns_errors_on_invalid_data()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'username' => 'anakin',
        ]);
        $input_data = [
            'username' => '',
        ];

        $this->put(route('admin.users.update', $user), $input_data)
            ->assertSessionHasErrors()
            ->assertSessionHas('errors');
    }

    /** @test */
    public function delete_returns_proper_content()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->get(route('admin.users.delete', $user))
            ->assertOk()
            ->assertViewIs('admin.user.delete')
            ->assertSee($user->name);
    }

    /** @test */
    public function destroy_deletes_an_object()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->delete(route('admin.users.destroy', $user))
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');
    }

    /** @test */
    public function data_returns_proper_content()
    {
        // One user has already been created by setUp().
        User::factory()->count(3)->create();

        $this->withoutMiddleware(OnlyAjax::class)
            ->get(route('admin.users.data'))
            ->assertJsonCount(5, 'data');
    }

    /** @test */
    public function data_fails_for_non_ajax_calls()
    {
        // One user has already been created by setUp().
        User::factory()->count(3)->create();

        $this->get(route('admin.users.data'))
            ->assertForbidden();
    }
}
