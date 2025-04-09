<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use BaleBot\Controllers\BotController;


Route::post('/bale/webhook', [BotController::class, 'handle']);
Route::post('/bale/callback', [BotController::class, 'handleCallback']);
