<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use IrngvPoll\Controllers\GetIrngvUserController;

Route::name('irngvPoll.')->prefix('irngv-poll')->middleware(['web', 'auth'])->group(function(){
    Route::get('get-users/{agency_code}', [GetIrngvUserController::class, 'getUsers'])->name('getUsers');
});
