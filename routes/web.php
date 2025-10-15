<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ReviewController;

Route::apiResource('books', BookController::class); //->only(['index', 'show']);
Route::apiResource('reviews', ReviewController::class); //->only(['index', 'show']);