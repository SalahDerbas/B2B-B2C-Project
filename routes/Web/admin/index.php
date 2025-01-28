<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\admin\HomeController;
use App\Http\Controllers\Web\admin\AdminController;
use App\Http\Controllers\Web\admin\CategoryController;
use App\Http\Controllers\Web\admin\CountryController;
use App\Http\Controllers\Web\admin\ItemController;
use App\Http\Controllers\Web\admin\LookupController;
use App\Http\Controllers\Web\admin\OrderController;
use App\Http\Controllers\Web\admin\PaymentController;
use App\Http\Controllers\Web\admin\SourceController;
use App\Http\Controllers\Web\admin\PromoCodeController;
use App\Http\Controllers\Web\admin\UserPromoCodeController;
use App\Http\Controllers\Web\admin\BillingController;
use App\Http\Controllers\Web\admin\B2BController;



use App\Http\Middleware\Admin;

/*
|--------------------------------------------------------------------------
| Group of Auth Routes
|--------------------------------------------------------------------------
* @author Salah Derbas
*/

Route::get('login',             [AuthController::class, 'loginAdminPage'])->name('admin.auth.loginAdminPage');
Route::post('login',            [AuthController::class, 'loginAdmin'])->name('admin.auth.loginAdmin');


Route::middleware([Admin::class])->group(function () {

    Route::get('home',            [HomeController::class, 'index'])->name('admin.home');


    Route::prefix('admins')->group(function () {

        Route::get('',                            [AdminController::class, 'index'])->name('admin.admins.index');
        Route::get('create',                      [AdminController::class, 'create'])->name('admin.admins.create');
        Route::get('edit',                        [AdminController::class, 'edit'])->name('admin.admins.edit');
        Route::post('store',                      [AdminController::class, 'store'])->name('admin.admins.store');
        Route::post('update',                     [AdminController::class, 'update'])->name('admin.admins.update');
        Route::delete('delete',                   [AdminController::class, 'delete'])->name('admin.admins.delete');
        Route::get('switch-status',               [AdminController::class, 'switchStatus'])->name('admin.admins.switchStatus');
    });


    Route::prefix('categories')->group(function () {

        Route::get('',                         [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('create',                   [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::get('edit',                     [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::post('store',                   [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::post('update',                  [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('delete',                [CategoryController::class, 'delete'])->name('admin.categories.delete');
        Route::get('switch-status',            [CategoryController::class, 'switchStatus'])->name('admin.categories.switchStatus');
        Route::get('export/{category_id?}',    [CategoryController::class, 'export'])->name('admin.categories.export');
        Route::get('get-items',                [CategoryController::class, 'getItems'])->name('admin.categories.getItems');

    });

    Route::prefix('countries')->group(function () {

        Route::get('',                       [CountryController::class, 'index'])->name('admin.countries.index');
        Route::get('create',                 [CountryController::class, 'create'])->name('admin.countries.create');
        Route::get('edit',                   [CountryController::class, 'edit'])->name('admin.countries.edit');
        Route::post('store',                 [CountryController::class, 'store'])->name('admin.countries.store');
        Route::post('update',                [CountryController::class, 'update'])->name('admin.countries.update');
        Route::delete('delete',              [CountryController::class, 'delete'])->name('admin.countries.delete');

    });


    Route::prefix('items')->group(function () {

        Route::get('',                            [ItemController::class, 'index'])->name('admin.items.index');
        Route::get('show',                        [ItemController::class, 'show'])->name('admin.items.show');
        Route::get('create',                      [ItemController::class, 'create'])->name('admin.items.create');
        Route::get('edit',                        [ItemController::class, 'edit'])->name('admin.items.edit');
        Route::post('store',                      [ItemController::class, 'store'])->name('admin.items.store');
        Route::post('update',                     [ItemController::class, 'update'])->name('admin.items.update');
        Route::delete('delete',                   [ItemController::class, 'delete'])->name('admin.items.delete');
        Route::get('switch-status',               [ItemController::class, 'switchStatus'])->name('admin.items.switchStatus');
        Route::get('switch-slider',               [ItemController::class, 'switchSlider'])->name('admin.items.switchSlider');
        Route::get('export/{sub_category_id?}',   [ItemController::class, 'export'])->name('admin.items.export');

    });

    Route::prefix('lookups')->group(function () {

        Route::get('',                            [LookupController::class, 'index'])->name('admin.lookups.index');
        Route::get('edit',                        [LookupController::class, 'edit'])->name('admin.lookups.edit');
        Route::post('update',                     [LookupController::class, 'update'])->name('admin.lookups.update');


    });

    Route::prefix('orders')->group(function () {

        Route::get('',                       [OrderController::class, 'index'])->name('admin.orders.index');
    });

    Route::prefix('payments')->group(function () {

        Route::get('',                       [PaymentController::class, 'index'])->name('admin.payments.index');
        Route::get('create',                 [PaymentController::class, 'create'])->name('admin.payments.create');
        Route::get('edit',                   [PaymentController::class, 'edit'])->name('admin.payments.edit');
        Route::post('store',                 [PaymentController::class, 'store'])->name('admin.payments.store');
        Route::post('update',                [PaymentController::class, 'update'])->name('admin.payments.update');
        Route::delete('delete',              [PaymentController::class, 'delete'])->name('admin.payments.delete');
        Route::get('switch-status',          [PaymentController::class, 'switchStatus'])->name('admin.payments.switchStatus');


    });

    Route::prefix('sources')->group(function () {

        Route::get('',                       [SourceController::class, 'index'])->name('admin.sources.index');
        Route::get('create',                 [SourceController::class, 'create'])->name('admin.sources.create');
        Route::get('edit',                   [SourceController::class, 'edit'])->name('admin.sources.edit');
        Route::post('store',                 [SourceController::class, 'store'])->name('admin.sources.store');
        Route::post('update',                [SourceController::class, 'update'])->name('admin.sources.update');
        Route::delete('delete',              [SourceController::class, 'delete'])->name('admin.sources.delete');
        Route::get('switch-status',          [SourceController::class, 'switchStatus'])->name('admin.sources.switchStatus');

    });



    Route::prefix('b2bs')->group(function () {

        Route::get('',                            [B2BController::class, 'index'])->name('admin.b2bs.index');
        Route::get('create',                      [B2BController::class, 'create'])->name('admin.b2bs.create');
        Route::get('edit',                        [B2BController::class, 'edit'])->name('admin.b2bs.edit');
        Route::post('store',                      [B2BController::class, 'store'])->name('admin.b2bs.store');
        Route::post('update',                     [B2BController::class, 'update'])->name('admin.b2bs.update');
        Route::delete('delete',                   [B2BController::class, 'delete'])->name('admin.b2bs.delete');
        Route::get('switch-status',               [B2BController::class, 'switchStatus'])->name('admin.b2bs.switchStatus');
        Route::get('edit-operaters',              [B2BController::class, 'editOperaters'])->name('admin.b2bs.editOperaters');
        Route::post('update-operaters',           [B2BController::class, 'updateOperaters'])->name('admin.b2bs.updateOperaters');
        Route::get('new-operaters',               [B2BController::class, 'newOperaters'])->name('admin.b2bs.newOperaters');
        Route::post('add-operaters',              [B2BController::class, 'addOperaters'])->name('admin.b2bs.addOperaters');
        Route::get('items',                       [B2BController::class, 'getItems'])->name('admin.b2bs.getItems');

    });



    Route::prefix('promo_codes')->group(function () {

        Route::get('',                       [PromoCodeController::class, 'index'])->name('admin.promo_codes.index');
    });


    Route::prefix('user_promo_codes')->group(function () {

        Route::get('',                       [UserPromoCodeController::class, 'index'])->name('admin.user_promo_codes.index');
    });

    Route::prefix('billings')->group(function () {

        Route::get('',                       [BillingController::class, 'index'])->name('admin.billings.index');
        Route::get('show',                   [BillingController::class, 'show'])->name('admin.billings.show');
        Route::get('download',               [BillingController::class, 'download'])->name('admin.billings.download');
        Route::get('approve',                [BillingController::class, 'approve'])->name('admin.billings.approve');
        Route::get('reject',                 [BillingController::class, 'reject'])->name('admin.billings.reject');
        Route::get('export',                 [BillingController::class, 'export'])->name('admin.billings.export');

    });





    /*
    |--------------------------------------------------------------------------
    | Logout B2B Route
    |--------------------------------------------------------------------------
    * @author Salah Derbas
    */
    Route::get('logout',       [AuthController::class, 'logoutAdmin'])->name('admin.auth.logout');

});
