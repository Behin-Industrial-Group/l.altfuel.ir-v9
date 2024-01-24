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

Route::get('/hidro/get', [HidroController::class, 'createApi']);
Route::get('/agencies/get', [MarakezController::class, 'createApi']);

Route::prefix('/hamayesh/')->group(function(){
    Route::post('workshop', [HamayeshController::class, 'register_workshop'])->name('register_workshop');
});

Route::prefix('irngv')->group(function(){
    Route::any('get-token', [IrngvApiController::class, 'get_token'])->middleware('api_auth');
    Route::any('poll-link', [IrngvApiController::class, 'send_sms'])->middleware('api_access');
});

Route::name('blog.')->prefix('blog')->group(function(){
    Route::get('/get', []);
    Route::get('/get-by-catagory/{catagory}', [BlogController::class, 'getByCatagory']);
    Route::get('get-by-id/{id}', [BlogController::class, 'getById'])->name('getById');
});
