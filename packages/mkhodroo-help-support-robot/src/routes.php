<?php

use Illuminate\Support\Facades\Route;
use Mkhodroo\HelpSupportRobot\Controllers\AddController;
use Mkhodroo\HelpSupportRobot\Controllers\GetController;
use Mkhodroo\PMReport\Controllers\CurlRequestController;
use Mkhodroo\PMReport\Controllers\TableController;
use Mkhodroo\PMReport\Controllers\VacationController;
use Mkhodroo\Voip\Controllers\VoipController;

Route::name('helpSupport.')->prefix('help-support-robot')->middleware(['web', 'auth', 'access'])->group(function(){
    Route::get('get-form', [GetController::class, 'getForm'])->name('getForm');
    Route::post('get', [GetController::class, 'getByParentId'])->name('get');
    Route::get('add-form', [AddController::class, 'addForm'])->name('addForm');
    Route::post('add', [AddController::class, 'add'])->name('add');
});