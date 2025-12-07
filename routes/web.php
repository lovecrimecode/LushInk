<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Api\BookApiController;
use App\Http\Controllers\PurchaseController;
use App\Models\Book;
use Illuminate\Support\Facades\Route;

 Route::get('/', [BookApiController::class, 'index']);

 Route::get('/books/{book}', [BookApiController::class, 'show']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('books', BookController::class);
});

use App\Http\Controllers\LibraryController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/library', [LibraryController::class, 'index']);
    Route::get('/library/{id}', [LibraryController::class, 'show']);
    Route::get('/library/{id}/read', [LibraryController::class, 'read']);
});s

// API externa (OpenLibrary)
Route::get('/search', [BookApiController::class, 'search']);
Route::get('/details/{id}', [BookApiController::class, 'details']);

Route::post('/purchase', [PurchaseController::class, 'purchase']);

require __DIR__.'/auth.php';
