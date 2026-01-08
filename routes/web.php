<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\LibraryController;
use App\Models\Book;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// API interna (requiere login)
Route::middleware('auth')->group(function () {
    Route::get('/library', [LibraryController::class, 'index'])->name('library');
    Route::get('/read/{book}', [LibraryController::class, 'read'])->name('read');
    //Route::get('/library/{id}', [LibraryController::class, 'show'])->name('library.show');
    //Route::get('/library/{id}/read', [LibraryController::class, 'read'])->name('read');
});

// API externa (OpenLibrary)
Route::get('/book/search', [PageController::class, 'search'])->name('book.search');
Route::get('/book/{id}', [PageController::class, 'details'])->name('book.details');

// Comprar libro
//Route::post('/purchase', [PurchaseController::class, 'purchase'])->name('purchase');

require __DIR__.'/auth.php';
