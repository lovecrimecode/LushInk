<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiBookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/books', [ApiBookController::class, 'index']);
Route::get('/books/{book}', [ApiBookController::class, 'show']);

Route::get('/search', [ApiBookController::class, 'search']);
Route::get('/details/{id}', [ApiBookController::class, 'details']);

