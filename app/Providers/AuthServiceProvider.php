<?php

namespace Gamify\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Gamify\Model' => 'Gamify\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        $gate->before(function ($user) {
            if ($user->username === 'admin') {
                return true;
            }
        });

        $gate->define('manage-users', function ($user) {
            return $user->role === 'administrator';
        });

        $gate->define('manage-questions', function ($user) {
            return $user->role === 'administrator';
        });

        $gate->define('manage-badges', function ($user) {
            return $user->role === 'administrator';
        });

        $gate->define('manage-levels', function ($user) {
            return $user->role === 'administrator';
        });

    }
}
