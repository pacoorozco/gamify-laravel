<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Some rights reserved. See LICENSE and AUTHORS files.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

namespace Gamify\Providers;

use Gamify\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * Policies are discovered automatically using the Policy Auto-Discovery.
     *
     * @see https://laravel.com/docs/9.x/authorization#policy-auto-discovery
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();
        $this->registerGamifyAbilities();
    }

    /**
     * Register custom Gamify authorization abilities.
     *
     * @return void
     */
    protected function registerGamifyAbilities(): void
    {
        Gate::define('access-dashboard', function (User $currentUser) {
            return $currentUser->isAdmin();
        });

        Gate::define('update-profile', function (User $currentUser, User $user) {
            return $currentUser->is($user);
        });

        Gate::define('update-password', function (User $currentUser, User $user) {
            return $currentUser->is($user);
        });

        // A user can not update its own role.
        Gate::define('update-role', function (User $currentUser, User $user) {
            return $currentUser->isAdmin()
                && $currentUser->isNot($user);
        });

        // A user can not delete itself.
        Gate::define('delete-user', function (User $currentUser, User $user) {
            return $currentUser->isAdmin()
                && $currentUser->isNot($user);
        });
    }
}
