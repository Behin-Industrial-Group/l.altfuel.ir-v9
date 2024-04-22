<?php

use Illuminate\Support\Facades\Route;
use UserProfile\Controllers\UserProfileController;

Route::name('user-profile.')->prefix('user-profile')->middleware(['web','auth'])->group(function(){
    Route::get('/', [UserProfileController::class, 'index'])->name('profile');
});
