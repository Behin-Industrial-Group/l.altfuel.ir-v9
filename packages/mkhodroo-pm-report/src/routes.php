<?php

use Illuminate\Support\Facades\Route;
use Mkhodroo\PMReport\Controllers\CurlRequestController;
use Mkhodroo\PMReport\Controllers\VacationController;
use Mkhodroo\Voip\Controllers\VoipController;

Route::name('PMReport.')->prefix('pm-report')->middleware(['web', 'auth', 'access'])->group(function(){
    Route::get('number-of-vacation', [VacationController::class, 'getNumberOfVacation'])->name('getNumberOfVacation');
    
    Route::get('test', function(){
        $url = "/api/v1/table";
        $data = [
            'api_token' => 'asd',
            'table_name' => 'rbac_users'
        ];
        return CurlRequestController::post($url, $data);
    });
});