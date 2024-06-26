<?php

namespace Mkhodroo\PMReport;

use Illuminate\Support\ServiceProvider;

class PMReportProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__. '/Views', 'PMReportView');
        $this->loadJsonTranslationsFrom(__DIR__. '/Lang');
    }
}
