<?php

namespace App\Providers;

use App\Interfaces\FinanceServiceInterface;
use App\Services\FinanceService;
use Illuminate\Support\ServiceProvider;

class FinanceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FinanceServiceInterface::class, FinanceService::class);
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
