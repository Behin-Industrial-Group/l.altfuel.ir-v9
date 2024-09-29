<?php

namespace QrCodeScanner;

use Illuminate\Support\ServiceProvider;

class QrCodeScannerProvider extends ServiceProvider{
    public function register()
    {

    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/public' => public_path('packages/behin-qrcode-scanner-input/')
        ]);
        $this->loadViewsFrom(__DIR__.'/Views', 'QrCodeView');

    }
}
