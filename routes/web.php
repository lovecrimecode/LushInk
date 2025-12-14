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
    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
    Route::get('/library/{id}', [LibraryController::class, 'show'])->name('library.show');
    Route::get('/library/{id}/read', [LibraryController::class, 'read'])->name('library.read');
});

// API externa (OpenLibrary)
Route::get('/search', [BookApiController::class, 'search'])->name('books.search');
Route::get('/details/{id}', [BookApiController::class, 'details'])->name('books.details');

Route::post('/purchase', [PurchaseController::class, 'purchase'])->name('purchase');

require __DIR__.'/auth.php';
