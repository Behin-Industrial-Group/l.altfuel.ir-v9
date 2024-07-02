<?php

namespace Mkhodroo\VacationRequest;

use Illuminate\Support\ServiceProvider;

class VacationRequestProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('voip-config.php')
        ]);
        $this->loadMigrationsFrom(__DIR__. '/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadJsonTranslationsFrom(__DIR__.'/Lang');
    }
}
