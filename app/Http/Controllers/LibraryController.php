<?php

namespace App\Http\Controllers;

use App\Models\Book;

class LibraryController extends Controller
{
    // Mostrar solo libros comprados
    public function index()
    {
        return auth()->user()->purchasedBooks()->get();
    }

    // Detalles de un libro comprado
    public function show($id)
    {
        $book = auth()->user()->purchasedBooks()->findOrFail($id);
        return $book;
    }

    public function read($id)
{
    // El usuario solo puede leer libros que compró
    $book = auth()->user()->purchasedBooks()->findOrFail($id);

    if (!$book->file_path) {
        return response()->json(['error' => 'Book content not found'], 404);
    }

    $file = storage_path("app/books/{$book->file_path}");

    if (!file_exists($file)) {
        return response()->json(['error' => 'File missing on server'], 404);
    }

    return response()->file($file);
}

}
