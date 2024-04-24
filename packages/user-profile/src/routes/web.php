<?php

use Illuminate\Support\Facades\Route;
use UserProfile\Controllers\ChangePasswordController;
use UserProfile\Controllers\NationalIdController;
use UserProfile\Controllers\UserProfileController;

Route::name('user-profile.')->prefix('user-profile')->middleware(['web','auth'])->group(function(){
    Route::get('/', [UserProfileController::class, 'index'])->name('profile');

    Route::get('/change-password', [ChangePasswordController::class, 'edit'])->name('change-password');
    Route::post('', [NationalIdController::class, 'store'])->name('storeNationalId');
    Route::put('/', [ChangePasswordController::class, 'update'])->name('update-password');

});
