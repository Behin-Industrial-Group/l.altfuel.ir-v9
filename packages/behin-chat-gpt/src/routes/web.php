<?php

use ChatGpt\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('chat-gpt', function () {
    return view('ChatGptViews::index');
});


Route::name('behinGPT.')->prefix('behin-gpt')->group(function(){
    Route::post('/chat', ChatController::class, '__invoke')->name('chat');

});
