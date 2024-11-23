<?php

use Illuminate\Support\Facades\Route;
use Registration\Controllers\RegisterUserController;

Route::name('azmoon.')->prefix('azmoon')->middleware(['web'])->group(function(){
    Route::get('/', [RegisterUserController::class, 'showForm'])->name('form');
    Route::post('/register', [RegisterUserController::class, 'submitForm'])->name('submit');
    Route::get('/verify', [RegisterUserController::class, 'verify'])->name('verify');
});
