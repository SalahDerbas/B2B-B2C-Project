<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Web\b2b\Auth\AuthContoller;
use App\Http\Controllers\Web\b2b\Dashboard\DashboardController;



Route::get('login',            [AuthContoller::class , 'loginPage' ])->name('b2b.auth.loginPage');
Route::get('check-otp',        [AuthContoller::class , 'checkOtpPage' ])->name('b2b.auth.checkOtpPage');

Route::post('login',           [AuthContoller::class , 'login' ])->name('b2b.auth.login');
Route::post('check-otp',       [AuthContoller::class , 'checkOtp' ])->name('b2b.auth.checkOtp');
Route::get('resend-otp',       [AuthContoller::class , 'resendOtp' ])->name('b2b.auth.resendOtp');

Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('b2b.dashboard');

Route::group( ['middleware' => ['auth']], function () {


    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('b2b.dashboard');

    Route::post('logout',    [AuthContoller::class , 'logout' ])->name('b2b.auth.logout');



});
