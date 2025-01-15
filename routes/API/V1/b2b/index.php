<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\b2b\Auth\AuthController;
use App\Http\Controllers\API\V1\b2b\Home\HomeController;
use App\Http\Controllers\API\V1\b2b\Home\Category\CategoryController;
use App\Http\Controllers\API\V1\b2b\Home\Item\ItemController;
use App\Http\Controllers\API\V1\b2b\Order\SubmitController;
use App\Http\Controllers\API\V1\b2b\Order\StatusPackageController;
use App\Http\Controllers\API\V1\b2b\Order\SharePackageController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('test', function (Request $request) {
    return "Done";
});




/*
|--------------------------------------------------------------------------
| Public User Routes
|--------------------------------------------------------------------------
* @author Salah Derbas
*/
Route::prefix('user')->group( function () {

    Route::post('login',               [AuthController::class, 'login'])->name('api.b2b.user.login');
    Route::post('forget-password',     [AuthController::class, 'forgetPassword'])->name('api.b2b.user.forget_password');
    Route::post('reset-password',      [AuthController::class, 'resetPassword'])->name('api.b2b.user.reset_password');
    Route::post('check-otp' ,          [AuthController::class, 'checkOtp'])->name('api.b2b.user.check_otp');
    Route::post('re-send-otp' ,        [AuthController::class, 'resendOtp'])->name('api.b2b.user.resend_otp');

});




/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
* @author Salah Derbas
*/
Route::group(['middleware' => ['auth:api' ]],function () {




/*
|--------------------------------------------------------------------------
| Home Routes API For B2C API
|--------------------------------------------------------------------------
* @author Salah Derbas
*/
Route::prefix('home')->group(function () {

    Route::get('search/{input}',      [HomeController::class, 'search'])->name('api.b2b.home.search');

    Route::prefix('category')->group(function () {

        Route::get('',         [CategoryController::class, 'index'])->name('api.b2b.home.category.index');
        Route::get('regional', [CategoryController::class, 'getRegional'])->name('api.b2b.home.category.getRegional');
        Route::get('local',    [CategoryController::class, 'getLocal'])->name('api.b2b.home.category.getLocal');
        Route::get('global',   [CategoryController::class, 'getGlobal'])->name('api.b2b.home.category.getGlobal');
        Route::get('{id}',     [CategoryController::class, 'show'])->name('api.b2b.home.category.show');
    });

    Route::prefix('items')->group(function () {

        Route::get('{sub_category_id}',  [ItemController::class, 'index'])->name('api.b2b.home.items.index');
        Route::get('show/{id}',          [ItemController::class, 'show'])->name('api.b2b.home.items.show');
    });


});




    /*
    |--------------------------------------------------------------------------
    | User Routes API With Authenticate
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */

    Route::prefix('user')->group( function () {

        Route::get('get-profile',             [AuthController::class, 'getProfile'])->name('api.b2b.user.get_profile');
        Route::get('get-balance',             [AuthController::class, 'getBalance'])->name('api.b2b.user.get_balance');
        Route::get('refresh-token',           [AuthController::class, 'refreshToken'])->name('api.b2b.user.refresh_token');
        Route::get('logout' ,                 [AuthController::class, 'logout'])->name('api.b2b.user.logout');


        /*
        |--------------------------------------------------------------------------
        | Orders Routes API For B2C API
        |--------------------------------------------------------------------------
        * @author Salah Derbas
        */
        Route::group(['prefix' => 'order'], function () {

            Route::prefix('submit-order')->group( function () {

                Route::post('pay',                [SubmitController::class, 'pay'])->name('api.b2b.user.order.pay');
            });

            Route::post('order-data',             [SubmitController::class, 'orderData'])->name('api.b2b.user.order.orderData');

            Route::prefix('packages')->group( function () {

                Route::get('',                [StatusPackageController::class, 'index'])->name('api.b2b.user.order.packages');
                Route::post('usage',          [StatusPackageController::class, 'usage'])->name('api.b2b.user.order.packages.usage');

                Route::post('get-qr',         [SharePackageController::class, 'getQR'])->name('api.b2b.user.order.packages.getQR');
                Route::post('reedem-qr',      [SharePackageController::class, 'reedemQR'])->name('api.b2b.user.order.packages.reedemQR');

            });

        });

    });
});
