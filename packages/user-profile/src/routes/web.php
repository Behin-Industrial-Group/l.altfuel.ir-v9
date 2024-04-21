<?php

use Illuminate\Support\Facades\Route;
use UserProfile\Controllers\UserProfileController;

Route::name('user-profile.')->prefix('user-profile')->middleware(['Auth'])->group(function(){
    Route::get('/', [UserProfileController::class])->name('profile');
});
