<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(base_path('routes/API/v1/index.php'));

Route::prefix('v2')->group(base_path('routes/API/v2/index.php'));