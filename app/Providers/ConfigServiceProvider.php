<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->booted(function(){
            $finConfig = config('fin.memberships');
            config(['app.agencies.high-pressure.payment' => $finConfig]);
            config(['app.agencies.hidro.payment' => $finConfig]);
            config(['app.agencies.low-pressure.payment' => $finConfig]);
            config(['app.agencies.high-pressure.extra-payment' => config('fin.extra-payments.high-pressure')]);
            config(['app.agencies.hidro.extra-payment' => config('fin.extra-payments.hidro')]);
            config(['app.agencies.low-pressure.extra-payment' => config('fin.extra-payments.low-pressure')]);

        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
