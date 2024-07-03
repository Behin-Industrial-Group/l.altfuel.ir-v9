<?php

use App\Models\MobileVerfication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mkhodroo\AgencyInfo\Controllers\GetAgencyController;
use UserProfile\Controllers\ChangePasswordController;
use UserProfile\Controllers\GetUserAgenciesController;
use UserProfile\Controllers\MobileVerificationController;
use UserProfile\Controllers\NationalIdController;
use UserProfile\Controllers\UserLevelController;
use UserProfile\Controllers\UserProfileController;

Route::name('user-profile.')->prefix('user-profile')->middleware(['web','auth'])->group(function(){
    Route::post('getUserAgencies', [GetUserAgenciesController::class, 'get'])->name('getUserAgencies');
    Route::get('agency/edit-location/{parent_id}', [GetUserAgenciesController::class, 'getLocation'])->name('getLocation');
    Route::post('participation', [GetUserAgenciesController::class, 'participation'])->name('participation');


    Route::get('/', [UserProfileController::class, 'index'])->name('profile');


    Route::get('/change-password', [ChangePasswordController::class, 'edit'])->name('change-password');
    Route::post('', [NationalIdController::class, 'store'])->name('storeNationalId');
    Route::patch('/', [ChangePasswordController::class, 'update'])->name('update-password');


    Route::post('/code', [MobileVerificationController::class, 'codeGenerator'])->name('codeGenerator');
    Route::post('/verify', [MobileVerificationController::class, 'verify'])->name('verify');


    Route::get('level-setter/{user_id}', [UserLevelController::class, 'levelSetter'])->name('level-setter');
});
