<?php 

namespace Mkhodroo\AgencyInfo;

use Illuminate\Support\ServiceProvider;

class AgencyInfoProvider extends ServiceProvider
{
    public function register() {
        
    }

    public function boot() {
        $this->publishes([
            __DIR__ . '/agency_info.php' => config_path('agency_info.php'),
        ]);
        $this->loadMigrationsFrom(__DIR__ . "/Migrations");
        $this->loadRoutesFrom(__DIR__. '/routes.php');;
        $this->loadViewsFrom(__DIR__. '/Views', 'AgencyView');
        $this->loadJsonTranslationsFrom(__DIR__.'/Lang/');
    }
}