<?php

namespace Tests;

use Gamify\Question;
use Gamify\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Return an admin user.
     *
     * @param array $overrides - Set attributes to the user.
     *
     * @return \Gamify\User $admin
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
     * @return \Gamify\User
     */
    protected function user(array $overrides = []): User
    {
        return factory(User::class)->states('with_profile')
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

    /**
     * Create Questions acting as Admin user to honor Blameable Trait.
     *
     * @param int   $number
     * @param array $overrides
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function createQuestionAsAdmin(int $number = 1, array $overrides = []): Collection
    {
        $this->actingAsAdmin();

        return factory(Question::class, $number)
            ->states('with_choices')
            ->create($overrides);
    }
}
