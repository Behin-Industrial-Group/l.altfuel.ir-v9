<?php

use AiAssistant\Controllers\SpeechToTextController;
use AiAssistant\Controllers\TextToSpeechController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('aiAssistant.')->prefix('ai-assistant')->group(function(){
    Route::get('/text-to-speech', [TextToSpeechController::class, 'sendText'])->name('sendText');
    Route::post('/speech-to-text', [SpeechToTextController::class, 'sendSpeech'])->name('sendSpeech');
});
