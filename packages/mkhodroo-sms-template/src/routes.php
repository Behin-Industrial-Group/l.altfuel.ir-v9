<?php

use Illuminate\Support\Facades\Route;
use Mkhodroo\SmsTemplate\Controllers\SmsTemplateController;
use Mkhodroo\Voip\Controllers\VoipController;

Route::name('smsTemplate.')->prefix('sms-template')->group(function(){
    Route::get('{sms_id}/{to}/{params?}', [SmsTemplateController::class, 'send'])->name('send');
});