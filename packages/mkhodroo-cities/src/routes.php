<?php

use Illuminate\Support\Facades\Route;
use Mkhodroo\Cities\Controllers\CityController;

Route::name('city.')->prefix('city')->middleware(['web'])->group(function(){
    Route::get('all', [CityController::class ,'all'])->name('all');
});