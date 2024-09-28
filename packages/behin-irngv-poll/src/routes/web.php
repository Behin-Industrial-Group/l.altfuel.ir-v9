<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use IrngvPoll\Controllers\GetIrngvUserController;

Route::name('irngvPoll.')->prefix('irngv-poll')->middleware(['web', 'auth'])->group(function(){
    Route::get('get-users/{agency_code}', [GetIrngvUserController::class, 'getUsers'])->name('getUsers');
    Route::any('get-answers', [GetIrngvUserController::class, 'getAnswers'])->name('getAnswers');
    Route::any('get-infos', [GetIrngvUserController::class, 'getInfos'])->name('getInfos');
});
