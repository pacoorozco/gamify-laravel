<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This file is part of some open source application.
 *
 * Licensed under GNU General Public License 3.0.
 * Some rights reserved. See LICENSE, AUTHORS.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-l5
 */

namespace Gamify\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Gamify\Model' => 'Gamify\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerGamifyPolicies();
    }

    /**
     * Register custom Gamify authentication / authorization services.
     *
     * @return void
     */
    public function registerGamifyPolicies()
    {
        Gate::define('manage-users', function ($user) {
            return $user->role === 'administrator';
        });
        Gate::define('manage-questions', function ($user) {
            return $user->role === 'editor' || $user->role === 'administrator';
        });
        Gate::define('manage-badges', function ($user) {
            return $user->role === 'administrator';
        });
        Gate::define('manage-levels', function ($user) {
            return $user->role === 'administrator';
        });
    }
}
