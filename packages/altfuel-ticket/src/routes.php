<?php 

namespace Mkhodroo\AltfuelTicket;

use Mkhodroo\AltfuelTicket\Controllers\CreateTicketController;
use Illuminate\Support\Facades\Route;
use Mkhodroo\AltfuelTicket\Controllers\GetTicketController;
use Mkhodroo\AltfuelTicket\Controllers\ShowTicketController;
use Mkhodroo\AltfuelTicket\Controllers\TicketCatagoryController;

Route::name('ATRoutes.')->prefix(config('ATConfig.route-prefix') . 'tickets')->middleware(['web','auth', 'access'])->group(function(){
    Route::get('', [CreateTicketController::class, 'index'])->name('index');
    Route::post('store', [CreateTicketController::class, 'store'])->name('store');
    Route::post('change-catagory', [TicketCatagoryController::class, 'changeCatagory'])->name('changeCatagory');

    Route::name('show.')->prefix('show')->group(function(){
        Route::get('all', [ShowTicketController::class, 'list'])->name('listForm');
        Route::post('', [ShowTicketController::class, 'show'])->name('ticket');
    });
    Route::name('get.')->prefix('get')->group(function(){
        Route::get('all', [GetTicketController::class, 'getAll'])->name('getAll');
        Route::get('get-mine', [GetTicketController::class, 'getMyTickets'])->name('getMyTickets');
        Route::post('get-by-catagory', [GetTicketController::class, 'getByCatagory'])->name('getByCatagory');
        Route::get('{id}', [GetTicketController::class, 'get'])->name('get');
    });

    Route::name('catagory.')->prefix('catagory')->group(function(){
        Route::get('all-parent', [TicketCatagoryController::class, 'getAllParent'])->name('getAllParent');
        Route::get('get-children/{parent_id?}', [TicketCatagoryController::class, 'getChildrenByParentId'])->name('getChildrenByParentId');
        Route::get('count/{id?}', [TicketCatagoryController::class, 'count'])->name('count');
    });
});
