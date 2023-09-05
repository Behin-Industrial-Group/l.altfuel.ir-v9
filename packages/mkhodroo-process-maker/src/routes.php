<?php 

namespace Mkhodroo\MkhodrooProcessMaker;

use Illuminate\Support\Facades\Route;
use Mkhodroo\MkhodrooProcessMaker\Controllers\CaseController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\InboxController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\PMVacationController;

Route::name('MkhodrooProcessMaker.')->prefix('pm')->middleware(['web', 'auth', 'access'])->group(function(){
    Route::get('inbox', [CaseController::class, 'get'])->name('inbox');
    Route::get('new-case', [CaseController::class, 'newCase'])->name('newCase');
    Route::name('report.')->prefix('report')->group(function(){
        Route::get('number-of-my-vacations', [PMVacationController::class, 'numberOfMyVacation'])->name('numberOfMyVacation');
    });
});