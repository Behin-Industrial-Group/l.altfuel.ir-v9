<?php

use Illuminate\Support\Facades\Route;
use Mkhodroo\DateConvertor\Controllers\SDate;
use Mkhodroo\Voip\Controllers\VoipController;

Route::name('dateConvert.')->prefix('date-convert')->group(function(){
    Route::get('auto/{date}', [SDate::class, 'convertDate'])->name('auto');
    Route::get('to-gr/{date}', [SDate::class, 'toGrDate'])->name('toGr');
    Route::get('to-sha/{date}', [SDate::class, 'toShaDate'])->name('toSha');
});