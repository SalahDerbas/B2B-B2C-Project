<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->group(base_path('routes/Web/admin/index.php'));

Route::prefix('b2b')->group(base_path('routes/Web/b2b/index.php'));

Route::prefix('webview')->group(base_path('routes/WebView/index.php'));

