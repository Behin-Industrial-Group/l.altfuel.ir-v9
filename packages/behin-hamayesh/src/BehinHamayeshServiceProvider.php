<?php

namespace Behin\Hamayesh;

use Illuminate\Support\ServiceProvider;

class BehinHamayeshServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'event-verification');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
    }

    public function register()
    {
        //
    }
}