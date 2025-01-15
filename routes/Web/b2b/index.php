<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Web\Auth\AuthController;

use App\Http\Controllers\Web\b2b\HomeController;
use App\Http\Controllers\Web\b2b\ManageEsimController;
use App\Http\Controllers\Web\b2b\APIOrderController;
use App\Http\Controllers\Web\b2b\APIIntegrationController;
use App\Http\Controllers\Web\b2b\UserController;
use App\Http\Controllers\Web\b2b\CreditController;
use App\Http\Controllers\Web\b2b\BillingController;
use App\Http\Controllers\Web\b2b\AnalyticsController;
use App\Http\Controllers\Web\b2b\FAQController;
use App\Http\Controllers\Web\b2b\RunPostmanController;
use App\Http\Controllers\Web\b2b\APIDocumentController;

use App\Http\Middleware\B2B;



/*
|--------------------------------------------------------------------------
| Authenticated B2B Routes
|--------------------------------------------------------------------------
* @author Salah Derbas
*/
Route::middleware([B2B::class])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard B2B Route
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::get('home',            [HomeController::class, 'index'])->name('b2b.home');

    /*
    |--------------------------------------------------------------------------
    | E-sims B2B Route
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::prefix('manage-esims')->group(function () {

        Route::get('',                       [ManageEsimController::class, 'index'])->name('b2b.manage_esims.index');
        Route::get('export/{category_id?}',  [ManageEsimController::class, 'export'])->name('b2b.manage_esims.export');
        Route::get('exportEsim/{id}',        [ManageEsimController::class, 'exportEsim'])->name('b2b.manage_esims.export_esim');
        Route::get('show/{id}',              [ManageEsimController::class, 'showEsim'])->name('b2b.manage_esims.showEsim');

    });

    /*
    |--------------------------------------------------------------------------
    | API Ordres B2B Route
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::prefix('api-orders')->group(function () {

        Route::get('',                  [APIOrderController::class, 'index'])->name('b2b.api_orders.index');
        Route::get('show/{id}',         [APIOrderController::class, 'show'])->name('b2b.api_orders.show');
        Route::get('export/{id}',       [APIOrderController::class, 'exportOrder'])->name('b2b.api_orders.exportOrder');
        Route::get('export',            [APIOrderController::class, 'export'])->name('b2b.api_orders.export');

    });


    /*
    |--------------------------------------------------------------------------
    | API Integration B2B Route
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::prefix('api-integration')->group(function () {

        Route::get('',                [APIIntegrationController::class, 'index'])->name('b2b.api_integration.index');
    });


    /*
    |--------------------------------------------------------------------------
    | User (Profile) B2B Route
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::prefix('user')->group(function () {

        Route::get('',                [UserController::class, 'index'])->name('b2b.user.index');
        Route::get('edit',            [UserController::class, 'edit'])->name('b2b.user.edit');
    });


    /*
    |--------------------------------------------------------------------------
    | Credit B2B Route
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::prefix('credits')->group(function () {

        Route::get('',                [CreditController::class, 'index'])->name('b2b.credits.index');
        Route::post('',               [CreditController::class, 'store'])->name('b2b.credits.store');
    });


    /*
    |--------------------------------------------------------------------------
    | Billing B2B Route
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::prefix('billing')->group(function () {

        Route::get('',                 [BillingController::class, 'index'])->name('b2b.billing.index');
        Route::get('show/{id}',        [BillingController::class, 'show'])->name('b2b.billing.show');
        Route::get('download/{id}',    [BillingController::class, 'download'])->name('b2b.billing.download');

    });

    /*
    |--------------------------------------------------------------------------
    | Billing B2B Route
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::prefix('analytics')->group(function () {

        Route::get('',                [AnalyticsController::class, 'index'])->name('b2b.analytics.index');
    });

    /*
    |--------------------------------------------------------------------------
    | FAQ B2B Route
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::prefix('help')->group(function () {

        Route::get('',                [FAQController::class, 'index'])->name('b2b.faq.index');
    });

    /*
    |--------------------------------------------------------------------------
    | Run-Postman B2B Route
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::prefix('run-postman')->group(function () {

        Route::get('',                    [RunPostmanController::class, 'index'])->name('b2b.run_postman.index');
        Route::get('download/{version}',  [RunPostmanController::class, 'download'])->name('b2b.run_postman.download');
    });

    /*
    |--------------------------------------------------------------------------
    | API Document B2B Route
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::prefix('api-documents')->group(function () {

        Route::get('',                [APIDocumentController::class, 'index'])->name('b2b.api_documents.index');
    });

    /*
    |--------------------------------------------------------------------------
    | Logout B2B Route
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::get('logout',       [AuthController::class, 'logout'])->name('auth.logout');
});
