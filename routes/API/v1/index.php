<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
* @author Salah Derbas
*/


Route::get('test', function (Request $request) {
    return "Done";
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
