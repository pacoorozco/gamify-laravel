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

use Gamify\Models\Badge;
use Gamify\Models\Level;
use Gamify\Models\Question;
use Gamify\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard';

    public function boot(): void
    {
        $this
            ->configureRateLimiting()
            ->registerBindings()
            ->mapRoutes();
    }

    protected function mapRoutes(): self
    {
        return $this
            ->mapAuthRoutes()
            ->mapApiRoutes()
            ->mapWebRoutes();
    }

    protected function mapWebRoutes(): self
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));

        return $this;
    }

    protected function mapApiRoutes(): self
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));

        return $this;
    }

    protected function mapAuthRoutes(): self
    {
        Route::prefix('auth')
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/auth.php'));

        return $this;
    }

    protected function registerBindings(): self
    {
        Route::model('users', User::class);
        Route::model('badges', Badge::class);
        Route::model('levels', Level::class);
        Route::model('questions', Question::class);

        Route::bind('username', function ($value) {
            return User::where('username', $value)->firstOrFail();
        });

        Route::bind('questionname', function ($value) {
            return Question::where('short_name', $value)->firstOrFail();
        });

        return $this;
    }

    protected function configureRateLimiting(): self
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });

        return $this;
    }
}
