<?php

use App\Http\Controllers\Api\QuotesApiController;
use Illuminate\Support\Facades\Route;

Route::get('/quotes', [QuotesApiController::class, 'retrieve']);
