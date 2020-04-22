<?php

namespace Gamify\Providers;

use Gamify\Http\View\Composers\UserHeaderComposer;
use Gamify\Http\View\Composers\UserSidebarComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            ['partials.user_dropdown'], UserHeaderComposer::class
        );
        View::composer(
            ['partials.sidebar'], UserSidebarComposer::class
        );
    }
}
