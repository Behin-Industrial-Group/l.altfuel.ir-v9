<?php 

namespace Mkhodroo\AltfuelTicket;

use Mkhodroo\AltfuelTicket\Controllers\CreateTicketController;
use Illuminate\Support\Facades\Route;
use Mkhodroo\AltfuelTicket\Controllers\TicketCatagoryController;

Route::name('ATRoutes.')->prefix(config('ATConfig.route-prefix') . 'tickets')->middleware(['web','auth'])->group(function(){
    Route::get('', [CreateTicketController::class, 'index'])->name('index');
    Route::post('store', [CreateTicketController::class, 'store'])->name('store');

    Route::name('catagory.')->prefix('catagory')->group(function(){
        Route::get('all-parent', [TicketCatagoryController::class, 'getAllParent'])->name('getAllParent');
        Route::get('get-children/{parent_id?}', [TicketCatagoryController::class, 'getChildrenByParentId'])->name('getChildrenByParentId');
    });
});