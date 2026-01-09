<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiBookController;
use App\Http\Controllers\Api\ApiLibraryController;

Route::get('/books', [ApiBookController::class, 'index']);
Route::get('/books/{book}', [ApiBookController::class, 'show']);

Route::get('/search', [ApiBookController::class, 'search']);
Route::get('/details/{id}', [ApiBookController::class, 'details']);

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/library', [ApiLibraryController::class, 'index']);
    Route::get('/library/{book}', [ApiLibraryController::class, 'show']);
});
