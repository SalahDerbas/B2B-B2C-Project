<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Middleware\EncryptCookies;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
* @author Salah Derbas
*/

Route::get('/test', function () {
    return phpinfo();
});

Route::middleware([EncryptCookies::class])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Home Page Route
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::get('/', function () {
        return view('welcome');
    });

    /*
    |--------------------------------------------------------------------------
    | Group of admin Routes
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::prefix('admin')->group(base_path('routes/Web/admin/index.php'));

    /*
    |--------------------------------------------------------------------------
    | Group of b2b Routes
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::prefix('b2b')->group(base_path('routes/Web/b2b/index.php'));

    /*
    |--------------------------------------------------------------------------
    | Group of web view Routes
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::prefix('webview')->group(base_path('routes/WebView/index.php'));




    /*
    |--------------------------------------------------------------------------
    | Group of Auth Routes
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::get('login',             [AuthController::class, 'loginPage'])->name('auth.loginPage');
    Route::get('check-otp',         [AuthController::class, 'checkOtpPage'])->name('auth.checkOtpPage');
    Route::post('login',            [AuthController::class, 'login'])->name('auth.login');
    Route::post('check-otp',        [AuthController::class, 'checkOtp'])->name('auth.checkOtp');
    Route::get('resend-otp',        [AuthController::class, 'resendOtp'])->name('auth.resendOtp');


});
