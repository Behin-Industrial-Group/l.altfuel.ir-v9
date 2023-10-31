<?php

namespace Mkhodroo\HelpSupportRobot;

use Illuminate\Support\ServiceProvider;

class HelpSupportRobotProvider extends ServiceProvider
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
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        $this->loadViewsFrom(__DIR__. '/Views', 'HelpSupportView');
        $this->loadJsonTranslationsFrom(__DIR__. '/Lang');
    }
}
