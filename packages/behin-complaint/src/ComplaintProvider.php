<?php

namespace Behin\Complaint;

use Illuminate\Support\ServiceProvider;

class ComplaintProvider extends ServiceProvider
{
    public function register() {

    }

    public function boot() {
        $this->loadMigrationsFrom(__DIR__ . "/Migrations");
        $this->loadRoutesFrom(__DIR__. '/routes.php');
        $this->loadViewsFrom(__DIR__. '/views', 'ComplaintViews');
        $this->loadJsonTranslationsFrom(__DIR__.'/Lang');
    }
}
