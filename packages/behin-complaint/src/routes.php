<?php

use Behin\Complaint\Controllers\ComplaintController;
use Illuminate\Support\Facades\Route;

Route::name('complaint.')->prefix('complaint')->middleware(['web'])->group(function () {
    Route::get('create', [ComplaintController::class, 'create'])->name('create');
    Route::post('complaints', [ComplaintController::class, 'store'])->name('store');

    Route::get('list', [ComplaintController::class, 'list'])->name('list');

});
