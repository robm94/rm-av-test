<?php

use App\Http\Controllers\Api\QuotesApiController;
use App\Http\Middleware\ApiAuth;
use Illuminate\Support\Facades\Route;

Route::middleware([ApiAuth::class])->group(function () {
    Route::get('/quotes', [QuotesApiController::class, 'retrieve']);
    Route::get('/quotes/refresh', [QuotesApiController::class, 'refresh']);
});