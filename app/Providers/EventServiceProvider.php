<?php

namespace Gamify\Providers;

use Gamify\Events\PointCreated;
use Gamify\Events\QuestionAnswered;
use Gamify\Listeners\AddAchievements;
use Gamify\Listeners\AddReputation;
use Gamify\Listeners\IncrementBadgesOnQuestionAnswered;
use Gamify\Listeners\IncrementBadgesOnUserLogin;
use Gamify\Listeners\LogSuccessfulLogin;
use Gamify\Listeners\UpdateExperience;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        SocialiteWasCalled::class => [
            'SocialiteProviders\Okta\OktaExtendSocialite@handle',
        ],
        Login::class => [
            LogSuccessfulLogin::class,
            IncrementBadgesOnUserLogin::class,
        ],
        QuestionAnswered::class => [
            AddReputation::class,
            AddAchievements::class,
            IncrementBadgesOnQuestionAnswered::class,
        ],
        PointCreated::class => [
            UpdateExperience::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
