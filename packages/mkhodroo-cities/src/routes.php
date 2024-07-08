<?php

use Illuminate\Support\Facades\Route;
use Mkhodroo\Cities\Controllers\CityController;
use Mkhodroo\Cities\Controllers\CityViewController;

Route::name('city.')->prefix('city')->middleware(['web'])->group(function(){
    Route::get('all', [CityController::class ,'all'])->name('all');

    Route::get('index', [CityViewController::class ,'index'])->name('index');
    Route::get('list', [CityViewController::class ,'list'])->name('list');
    Route::post('create', [CityViewController::class ,'create'])->name('create');
    Route::post('edit', [CityViewController::class ,'edit'])->name('edit');
    Route::post('update', [CityViewController::class ,'update'])->name('update');

});
