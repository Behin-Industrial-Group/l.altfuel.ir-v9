<?php

use App\Models\MobileVerfication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mkhodroo\AgencyInfo\Controllers\AgencyController;
use Mkhodroo\AgencyInfo\Controllers\AgencyDocsController;
use MyAgencyInfo\Controllers\EditMyAgencyInfoController;

Route::name('myAgency.')->prefix('my-agency')->middleware(['web','auth'])->group(function(){
    Route::get('edit/{parent_id}', [EditMyAgencyInfoController::class, 'form'])->name('form');
    Route::post('docs-edit', [AgencyDocsController::class, 'docsEdit'])->name('docsEdit');
    Route::post('foreman-edit', [AgencyController::class, 'foremanEdit'])->name('foremanEdit');
    Route::post('inspection-edit', [AgencyController::class, 'InspectionEdit'])->name('InspectionEdit');


});
