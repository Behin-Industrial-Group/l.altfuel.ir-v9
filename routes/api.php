<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/hidro/base64:F+7j4LuufsQrddgaOV5/nT7YMQH/E9DvQkVG9MyV1+o=', [HidroController::class, 'createApi']);
Route::get('/marakez/base64:F+7j4LuufsQrddgaOV5/nT7YMQH/E9DvQkVG9MyV1+o=', [MarakezController::class, 'createApi']);

Route::prefix('/hamayesh/')->group(function(){
    Route::post('workshop', [HamayeshController::class, 'register_workshop'])->name('register_workshop');
});

Route::prefix('irngv')->group(function(){
    Route::post('get-token', [IrngvApiController::class, 'get_token'])->middleware('api_auth');
    Route::post('poll-link', [IrngvApiController::class, 'send_sms'])->middleware('api_access');
});
