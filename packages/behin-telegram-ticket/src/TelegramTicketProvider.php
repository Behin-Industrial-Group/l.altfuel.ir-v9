<?php

namespace TelegramTicket;

use Illuminate\Support\ServiceProvider;

class TelegramTicketProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'telegram-ticket');
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
    }
}
