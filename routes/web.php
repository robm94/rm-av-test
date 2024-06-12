<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuotesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/quotes', [QuotesController::class, 'show']);
    Route::get('/logout', [AuthController::class, 'logOut']);
});