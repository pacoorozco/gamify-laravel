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

use Gamify\Events\AvatarUploaded;
use Gamify\Events\PointCreated;
use Gamify\Events\PointDeleted;
use Gamify\Events\ProfileUpdated;
use Gamify\Events\QuestionAnswered;
use Gamify\Events\SocialLogin;
use Gamify\Listeners\AddBadgesOnAvatarUploaded;
use Gamify\Listeners\AddBadgesOnProfileUpdated;
use Gamify\Listeners\AddBadgesOnQuestionAnswered;
use Gamify\Listeners\AddBadgesOnUserLoggedIn;
use Gamify\Listeners\AddReputation;
use Gamify\Listeners\UpdateCachedUserExperience;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Okta\OktaExtendSocialite;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        SocialiteWasCalled::class => [
            OktaExtendSocialite::class,
        ],
        Login::class => [
            AddBadgesOnUserLoggedIn::class,
        ],
        QuestionAnswered::class => [
            AddReputation::class,
            AddBadgesOnQuestionAnswered::class,
        ],
        PointCreated::class => [
            UpdateCachedUserExperience::class,
        ],
        PointDeleted::class => [
            UpdateCachedUserExperience::class,
        ],
        SocialLogin::class => [
            AddBadgesOnUserLoggedIn::class,
        ],
        AvatarUploaded::class => [
            AddBadgesOnAvatarUploaded::class,
        ],
        ProfileUpdated::class => [
            AddBadgesOnProfileUpdated::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
