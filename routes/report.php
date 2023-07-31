<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mkhodroo\AltfuelTicket\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('report.')->prefix('report')->group(function(){
    Route::name('tickets.')->prefix('tickets')->group(function(){
        Route::get('number-of-each-catagory', [ReportController::class, 'numberOfEachCatagory']);
        Route::get('status-in-each-catagory', [ReportController::class, 'statusInEachCatagory']);
    });
});
