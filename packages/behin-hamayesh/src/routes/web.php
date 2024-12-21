<?php

use Illuminate\Support\Facades\Route;
use Behin\Hamayesh\Http\Controllers\EventVerificationController;

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'event-verification'], function () {
    Route::get('/import/{eventId}', [EventVerificationController::class, 'importForm'])->name('event-verification.import-form');
    Route::post('/import/{eventId}', [EventVerificationController::class, 'import'])->name('event-verification.import');
    Route::get('/verify/{eventId}', [EventVerificationController::class, 'verificationForm'])->name('event-verification.verify-form');
    Route::post('/verify/{eventId}', [EventVerificationController::class, 'verify'])->name('event-verification.verify');
});