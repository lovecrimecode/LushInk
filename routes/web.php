<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReadingProgressController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/library', [PageController::class, 'library'])->name('library');
    Route::get('/read/{book}', [LibraryController::class, 'read'])->name('read');

    Route::post('/purchase', [PurchaseController::class, 'purchase'])->name('purchase');
    Route::post('/books/{book}/progress', [ReadingProgressController::class, 'update'])->name('books.progress.update');
});

Route::get('/book/search', [PageController::class, 'search'])->name('book.search');
Route::get('/book/{id}', [PageController::class, 'show'])->name('book.show');
Route::get('/book/index', [PageController::class, 'index'])->name('book.index');

require __DIR__ . '/auth.php';
