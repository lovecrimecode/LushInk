<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function read(Request $request, Book $book)
    {
        $owns = $request->user()->purchasedBooks()->whereKey($book->id)->exists();
        abort_unless($owns, 403, 'No tienes acceso a este libro.');

        if (!$book->file_path) {
            return response()->json(['error' => 'Contenido no disponible'], 404);
        }

        $file = storage_path("app/{$book->file_path}");
        if (!is_file($file)) {
            return response()->json(['error' => 'Archivo no encontrado en el servidor'], 404);
        }

        return response()->file($file);
    }
}
