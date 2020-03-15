<?php

namespace Gamify\Providers;

use Gamify\Events\PointCreated;
use Gamify\Events\QuestionAnswered;
use Gamify\Listeners\AddReputation;
use Gamify\Listeners\LogSuccessfulLogin;
use Gamify\Listeners\UpdateBadgeRepetitions;
use Gamify\Listeners\UpdateExperience;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Login::class => [
            LogSuccessfulLogin::class,
        ],
        QuestionAnswered::class => [
            AddReputation::class,
            UpdateBadgeRepetitions::class,
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
