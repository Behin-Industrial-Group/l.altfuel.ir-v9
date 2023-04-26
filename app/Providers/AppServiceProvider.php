<?php

namespace App\Providers;

use App\CustomClasses\Access;
use App\Interfaces\DateFilterInterface;
use App\Interfaces\Filterable;
use App\Models\IrngvPollAnswer;
use App\Repository\IrngvPollRepository;
use App\Services\ColumnFilterService;
use App\Services\FilterModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DateFilterInterface::class, IrngvPollRepository::class);
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $access = new Access();
        $access->CheckClientIP();
        Schema::defaultStringLength(191);
        if(env('APP_ENV') === 'production') {
            \URL::forceScheme('https');
        }
    }
}
