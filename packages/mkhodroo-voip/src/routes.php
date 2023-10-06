<?php

use Illuminate\Support\Facades\Route;
use Mkhodroo\Voip\Controllers\VoipController;

Route::name('voip.')->prefix('voip')->group(function(){
    Route::get('sip-show-peers', [VoipController::class, 'sip_show_peers_status'])->name('sipShowPeers');
});