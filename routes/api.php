<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Message\MessageController;
use App\Http\Controllers\API\Lookup\LookupController;


Route::prefix('v1')->group(base_path('routes/API/V1/index.php'));

Route::prefix('v2')->group(base_path('routes/API/V2/index.php'));


/*
|--------------------------------------------------------------------------
| Lookups API For B2B & B2C API's
|--------------------------------------------------------------------------
* @author Salah Derbas
*/
Route::prefix('lookups')->group( function () {

    Route::get('countries',       [LookupController::class, 'countries'])->name('api.lookups.countries');

});


/*
|--------------------------------------------------------------------------
| Messages API For B2B & B2C API's
|--------------------------------------------------------------------------
* @author Salah Derbas
*/
Route::prefix('message')->group(function () {
    Route::get('',             [MessageController::class, 'index'])->name('api.message.index');
    Route::get('show/{code}',  [MessageController::class, 'show'])->name('api.message.show');
});

