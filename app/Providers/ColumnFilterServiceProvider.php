<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ColumnFilterService;
use App\Interfaces\ColumnFilterServiceInterface;

class ColumnFilterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ColumnFilterServiceInterface::class, ColumnFilterService::class);
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
