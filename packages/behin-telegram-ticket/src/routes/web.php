<?php

use Illuminate\Support\Facades\Route;
use TelegramTicket\Controllers\TelegramTicketController;

Route::middleware(['web', 'auth']) // یا middleware دلخواه
    ->prefix('admin/telegram-tickets')
    ->group(function () {
        Route::get('/', [TelegramTicketController::class, 'index'])->name('telegram-tickets.index');
        Route::post('/{id}/reply', [TelegramTicketController::class, 'reply'])->name('telegram-tickets.reply');
    });
