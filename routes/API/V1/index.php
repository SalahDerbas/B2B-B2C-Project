<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\b2c\Auth\AuthController;
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


    /*
    |--------------------------------------------------------------------------
    | Content Routes API For HR Project
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
| Authenticated User Routes
|--------------------------------------------------------------------------
* @author Salah Derbas
*/


Route::group(['middleware' => ['auth:api']],function () {

    /*
    |--------------------------------------------------------------------------
    | User Routes API With Authenticate
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */

    Route::prefix('user')->group( function () {

        Route::get('',                        [AuthController::class, 'index'])->name('api.user.index');
        Route::get('get-profile',             [AuthController::class, 'getProfile'])->name('api.user.get_profile');
        Route::get('refresh-token',           [AuthController::class, 'refreshToken'])->name('api.user.refresh_token');
        Route::get('logout' ,                 [AuthController::class, 'logout'])->name('api.user.logout');
        Route::post('store',                  [AuthController::class, 'store'])->name('api.user.store');
        Route::post('update-profile',         [AuthController::class, 'updateProfile'])->name('api.user.update_profile');
        Route::delete('delete',               [AuthController::class, 'delete'])->name('api.user.delete');
    });

        /*
        |--------------------------------------------------------------------------
        | Notification Routes API For HR Project
        |--------------------------------------------------------------------------
        * @author Salah Derbas
        */
        Route::prefix('notification')->group( function () {

            Route::get('list',                [NotificationController::class, 'index'])->name('api.user.notification.index');
            Route::get('update-enable',       [NotificationController::class, 'updateEnable'])->name('api.user.notification.update_enable');

        });

});


/*
|--------------------------------------------------------------------------
| Lookups API For HR Project
|--------------------------------------------------------------------------
* @author Salah Derbas
*/
Route::prefix('lookups')->group( function () {

    Route::get('countries',             [LookupController::class, 'countries'])->name('api.lookups.countries');

});


/*
|--------------------------------------------------------------------------
| Messages API For HR Project
|--------------------------------------------------------------------------
* @author Salah Derbas
*/
Route::prefix('message')->group(function () {
    Route::get('list',         [MessageController::class, 'index'])->name('api.message.index');
    Route::get('show/{code}',  [MessageController::class, 'show'])->name('api.message.show');
});

