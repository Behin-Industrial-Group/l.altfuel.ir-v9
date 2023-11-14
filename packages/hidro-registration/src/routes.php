<?php

use Hidro\Registration\Controllers\HidroRegController;
use Illuminate\Support\Facades\Route;
use Mkhodroo\Voip\Controllers\VoipController;

Route::name('hidroReg.')->prefix('hidro-registraiton')->middleware(['web'])->group(function(){
    // Route::get('upload-excel', [HidroRegController::class, 'uploadExcel'])->name('uploadExcel');
    Route::get('find-form', [HidroRegController::class, 'findForm'])->name('findForm');
    Route::post('compelete-info-form', [HidroRegController::class, 'compeleteInfoForm'])->name('compeleteInfoForm');
    Route::post('pay', [HidroRegController::class, 'pay'])->name('pay');
    Route::get('callback', [HidroRegController::class, 'callback'])->name('callback');
    
});