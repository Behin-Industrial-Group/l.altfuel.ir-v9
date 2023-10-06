<?php 

namespace Mkhodroo\MkhodrooProcessMaker;

use Illuminate\Support\Facades\Route;
use Mkhodroo\MkhodrooProcessMaker\Controllers\CaseController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\DraftCaseController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\DynaFormController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\GetCaseVarsController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\InboxController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\PMVacationController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\StartCaseController;
use Mkhodroo\MkhodrooProcessMaker\Controllers\ToDoCaseController;

Route::name('MkhodrooProcessMaker.')->prefix('pm')->middleware(['web', 'auth', 'access'])->group(function(){
    Route::get('inbox', [CaseController::class, 'get'])->name('inbox');
    Route::get('new-case', [CaseController::class, 'newCase'])->name('newCase');
    Route::name('report.')->prefix('report')->group(function(){
        Route::get('number-of-my-vacations', [PMVacationController::class, 'numberOfMyVacation'])->name('numberOfMyVacation');
    });
    Route::name('forms.')->prefix('forms')->group(function(){
        Route::get('start', [ToDoCaseController::class, 'form'])->name('start');
        Route::get('todo', [ToDoCaseController::class, 'form'])->name('todo');
        Route::get('draft', [DraftCaseController::class, 'form'])->name('draft');
    });

    Route::name('api.')->prefix('api')->group(function(){
        Route::get('start-case', [StartCaseController::class, 'get'])->name('startCase');
        Route::get('todo', [ToDoCaseController::class, 'getMyCase'])->name('todo');
        Route::get('draft', [DraftCaseController::class, 'getMyCase'])->name('draft');
        Route::post('get-case-dynaForm', [DynaFormController::class, 'get'])->name('getCaseDynaForm');
        Route::post('get-case-vars', [GetCaseVarsController::class, 'get'])->name('getCaseVars');
    });
});