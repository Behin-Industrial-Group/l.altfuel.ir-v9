<?php

use IsoAgent\Controllers\IsoAgentController;
use Illuminate\Support\Facades\Route;

Route::name('isoAgent.')->prefix('iso-agent')->middleware(['web', 'auth', 'access'])->group(function(){
    Route::get('/', [IsoAgentController::class, 'index'])->name('index');
    Route::post('/send-message', [IsoAgentController::class, 'sendMessage'])->name('sendMessage');
});
