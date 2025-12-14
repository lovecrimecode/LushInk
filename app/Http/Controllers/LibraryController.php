<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->purchasedBooks()->get();
    }

    public function show(Request $request, $id)
    {
        $book = $request->user()->purchasedBooks()->findOrFail($id);
        return $book;
    }

    public function read(Request $request, $id)
    {
        $book = $request->user()->purchasedBooks()->findOrFail($id);

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
