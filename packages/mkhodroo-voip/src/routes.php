<?php

use Illuminate\Support\Facades\Route;
use Mkhodroo\Voip\Controllers\VoipController;

Route::name('voip.')->prefix('voip')->middleware(['web', 'auth', 'access'])->group(function(){
    Route::get('sip-show-peers', [VoipController::class, 'sip_show_peers_status'])->name('sipShowPeers');
    Route::get('get-peer-poll-info/{queue_num}', [VoipController::class, 'getPeerPollInfo'])->name('getPeerPollInfo');
});