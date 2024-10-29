<?php

use Behin\Compliant\Controllers\ComplaintController;
use Illuminate\Support\Facades\Route;
use Mkhodroo\Cities\Controllers\CityController;
use Mkhodroo\Cities\Controllers\CityViewController;
use Mkhodroo\Cities\Controllers\ProvinceController;

Route::name('complaint.')->prefix('complaint')->middleware(['web'])->group(function () {
    Route::get('', function(){
        return view('ComplaintViews::emails.complaint_submitted');
    })->name('create');
    Route::get('create', [ComplaintController::class, 'create'])->name('create');
    Route::post('complaints', [ComplaintController::class, 'store'])->name('store');

    Route::get('list', [ComplaintController::class, 'list'])->name('list');

});
