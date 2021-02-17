<?php

namespace Tests;

use Gamify\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Return an admin user.
     *
     * @param array $overrides - Set attributes to the user.
     *
     * @return \Gamify\Models\User $admin
     */
    protected function admin(array $overrides = []): User
    {
        return $this->user([
            'role' => User::ADMIN_ROLE,
        ]);
    }

    /**
     * Return an user.
     *
     * @param array $overrides - Set attributes to the user.
     *
     * @return \Gamify\Models\User
     */
    protected function user(array $overrides = []): User
    {
        return User::factory()->states('with_profile')
            ->create($overrides);
    }

    /**
     * Acting as an admin.
     *
     * @param string|null $driver
     *
     * @return $this
     */
    protected function actingAsAdmin(string $driver = null)
    {
        $this->actingAs($this->admin(), $driver);

        return $this;
    }

    /**
     * Acting as an user.
     *
     * @param string|null $driver
     *
     * @return $this
     */
    protected function actingAsUser(string $driver = null)
    {
        $this->actingAs($this->user(), $driver);

        return $this;
    }
}
