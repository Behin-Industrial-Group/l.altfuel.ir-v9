<?php

use App\Http\Controllers\AsnafLPGController;
use App\Http\Controllers\IrngvPollAnswerController;
use App\Http\Controllers\IrngvUsersInfoController;
use Illuminate\Support\Facades\Route;


Route::prefix('asnaf-lpg')->group(function(){
    Route::get('', [AsnafLPGController::class, 'registerForm']);
    Route::post('register', [AsnafLPGController::class, 'register'])->name('asnafLPGRegistration');
});