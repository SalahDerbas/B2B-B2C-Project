<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebView\OrderController;

/*
|--------------------------------------------------------------------------
| Group of order web view Routes
|--------------------------------------------------------------------------
* @author Salah Derbas
*/
Route::group(['prefix' => 'order'], function () {

    Route::match(['GET','POST'],'callback',    [OrderController::class, 'callBack'])->name('order.callBack');
    Route::get('callback-failed',              [OrderController::class, 'failedPage'])->name('order.callBack.failed');
    Route::get('callback-success/{order_id}',  [OrderController::class, 'successPage'])->name('order.callBack.success');

});
