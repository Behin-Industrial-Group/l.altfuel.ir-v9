<?php

use Illuminate\Support\Facades\Route;
use Registration\Controllers\RegisterUserController;

Route::name('registration.')->prefix('registration')->middleware(['web'])->group(function(){
    Route::get('/register', [RegisterUserController::class, 'showForm'])->name('form');
    Route::post('/register', [RegisterUserController::class, 'submitForm'])->name('submit');
    Route::get('/verify', [RegisterUserController::class, 'verify'])->name('verify');
});
