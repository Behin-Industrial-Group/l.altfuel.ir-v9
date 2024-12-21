<?php

namespace Registration;

use Illuminate\Support\ServiceProvider;

class RegistrationServiceProvider extends ServiceProvider
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
            __DIR__. '/config/registration.php' => config_path('registration.php')
        ], 'registration');
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__. '/views', 'RegistrationViews');
        $this->loadJsonTranslationsFrom(__DIR__. '/Lang');
    }
}
