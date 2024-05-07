<?php

namespace ChatGpt;

use Illuminate\Support\ServiceProvider;

class ChatGptProvider extends ServiceProvider
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
        $this->publishes([
            __DIR__ . '/config/behin_gpt_config.php' => config_path('behin_gpt_config.php'),
            __DIR__ . '/public' => public_path('packages/behin-chat-gpt/')
        ]);
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__. '/views', 'ChatGptViews');
    }
}
