<?php

use App\Http\Controllers\IrngvPollAnswerController;
use App\Http\Controllers\IrngvUsersInfoController;
use Illuminate\Support\Facades\Route;


Route::name('inbox.')->prefix('inbox')->group(function(){
    Route::get('to-do',function(){
        return view('test');
    })->name('todo');
});