<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use TelegramBot\Controllers\BotController;

Route::name('telegramBot.')->prefix('telegram-bot')->group(function(){
    Route::get('/chat', [BotController::class, 'chat'])->name('chat');
});
