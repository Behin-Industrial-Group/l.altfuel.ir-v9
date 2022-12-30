<?php

use App\Http\Controllers\IrngvUsersInfoController;
use Illuminate\Support\Facades\Route;


Route::prefix('/irngv/')->group(function(){
    Route::get('poll/{link}', [IrngvUsersInfoController::class, 'show_poll']);
});