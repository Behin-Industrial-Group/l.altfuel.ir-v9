<?php

namespace Hidro\Registration;

use Illuminate\Support\ServiceProvider;

class HidroRegProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(__DIR__. '/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadViewsFrom(__DIR__. '/Views', 'HidroRegViews');
        $this->loadJsonTranslationsFrom(__DIR__.'/Lang');
    }
}
