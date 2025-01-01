<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\Lookup\LookupController;
use App\Http\Controllers\API\Message\MessageController;

use App\Http\Controllers\API\V1\b2c\Auth\AuthController;
use App\Http\Controllers\API\V1\b2c\Content\ContentController;
use App\Http\Controllers\API\V1\b2c\Notification\NotificationController;
use App\Http\Controllers\API\V1\b2c\Home\HomeController;
use App\Http\Controllers\API\V1\b2c\Home\Category\CategoryController;
use App\Http\Controllers\API\V1\b2c\Home\Item\ItemController;
use App\Http\Controllers\API\V1\b2c\Order\SubmitController;
use App\Http\Controllers\API\V1\b2c\Order\StatusPackageController;
use App\Http\Controllers\API\V1\b2c\Order\SharePackageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
* @author Salah Derbas
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

    Route::post('login',               [AuthController::class, 'login'])->name('api.user.login');
    Route::post('check-otp' ,          [AuthController::class, 'checkOtp'])->name('api.user.check_otp');
    Route::post('re-send-otp' ,        [AuthController::class, 'resendOtp'])->name('api.user.resend_otp');
    Route::post('login-by-google',     [AuthController::class, 'loginByGoogle'])->name('api.user.login_by_google');
    Route::post('login-by-facebook',   [AuthController::class, 'loginByFacebook'])->name('api.user.login_by_facebook');
    Route::post('login-by-apple',      [AuthController::class, 'loginByApple'])->name('api.user.login_by_apple');
    Route::post('forget-password',     [AuthController::class, 'forgetPassword'])->name('api.user.forget_password');
    Route::post('reset-password',      [AuthController::class, 'resetPassword'])->name('api.user.reset_password');
    Route::post('register',            [AuthController::class, 'register'])->name('api.user.register');

    /*
    |--------------------------------------------------------------------------
    | Content Routes API For B2C API
    |--------------------------------------------------------------------------
    * @author Salah Derbas
*/
    Route::prefix('content')->group( function () {

        Route::get('terms-conditions',     [ContentController::class, 'getTermsConditions'])->name('api.content.get_terms_conditions');
        Route::get('privacy-policy',       [ContentController::class, 'getPrivacyPolicy'])->name('api.content.get_privacy_policy');
        Route::get('about-us',             [ContentController::class, 'getAboutUs'])->name('api.content.get_about_us');
        Route::get('faq',                  [ContentController::class, 'getFAQ'])->name('api.content.get_faq');
        Route::get('sliders',              [ContentController::class, 'getSliders'])->name('api.content.get_sliders');
        Route::post('contact-us',          [ContentController::class, 'contactUs'])->name('api.content.contact_us');
    });

});



/*
|--------------------------------------------------------------------------
| Home Routes API For B2C API
|--------------------------------------------------------------------------
* @author Salah Derbas
*/
Route::prefix('home')->group(function () {

    Route::get('',                    [HomeController::class, 'index'])->name('api.home.index');
    Route::get('search/{input}',      [HomeController::class, 'search'])->name('api.home.search');
    Route::get('slider',              [HomeController::class, 'slider'])->name('api.home.slider');

    Route::prefix('category')->group(function () {

        Route::get('',         [CategoryController::class, 'index'])->name('api.home.category.index');
        Route::get('regional', [CategoryController::class, 'getRegional'])->name('api.home.category.getRegional');
        Route::get('local',    [CategoryController::class, 'getLocal'])->name('api.home.category.getLocal');
        Route::get('global',   [CategoryController::class, 'getGlobal'])->name('api.home.category.getGlobal');
        Route::get('{id}',     [CategoryController::class, 'show'])->name('api.home.category.show');
    });

    Route::prefix('items')->group(function () {

        Route::get('{sub_category_id}',  [ItemController::class, 'index'])->name('api.home.items.index');
        Route::get('show/{id}',          [ItemController::class, 'show'])->name('api.home.items.show');
    });


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
    | User Routes API With Authenticate
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */

    Route::prefix('user')->group( function () {

        Route::get('get-profile',             [AuthController::class, 'getProfile'])->name('api.user.get_profile');
        Route::get('refresh-token',           [AuthController::class, 'refreshToken'])->name('api.user.refresh_token');
        Route::get('logout' ,                 [AuthController::class, 'logout'])->name('api.user.logout');
        Route::post('update-profile',         [AuthController::class, 'updateProfile'])->name('api.user.update_profile');
        Route::delete('delete',               [AuthController::class, 'delete'])->name('api.user.delete');



        /*
        |--------------------------------------------------------------------------
        | Notification Routes API For HR Project
        |--------------------------------------------------------------------------
        * @author Salah Derbas
        */
        Route::prefix('notification')->group( function () {

            Route::get('',                    [NotificationController::class, 'index'])->name('api.user.notification.index');
            Route::get('update-enable',       [NotificationController::class, 'updateEnable'])->name('api.user.notification.update_enable');

        });

         /*
        |--------------------------------------------------------------------------
        | Orders Routes API For B2C API
        |--------------------------------------------------------------------------
        * @author Salah Derbas
        */
        Route::group(['prefix' => 'order'], function () {

            Route::prefix('submit-order')->group( function () {

                Route::post('pay',                [SubmitController::class, 'pay'])->name('api.user.order.pay');
                Route::post('check-promocode',    [SubmitController::class, 'checkPromocode'])->name('api.user.order.checkPromocode');
            });

            Route::post('order-data',             [SubmitController::class, 'orderData'])->name('api.user.order.orderData');

            Route::prefix('packages')->group( function () {

                Route::get('',                [StatusPackageController::class, 'index'])->name('api.user.order.packages');
                Route::post('usage',          [StatusPackageController::class, 'usage'])->name('api.user.order.packages.usage');

                Route::post('get-qr',         [SharePackageController::class, 'getQR'])->name('api.user.order.packages.getQR');
                Route::post('reedem-qr',      [SharePackageController::class, 'reedemQR'])->name('api.user.order.packages.reedemQR');

            });

        });


    });



});


