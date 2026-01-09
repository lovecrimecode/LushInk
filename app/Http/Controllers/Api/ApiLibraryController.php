<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class ApiLibraryController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            $request->user()->purchasedBooks()->latest()->get()
        );
    }

    public function show(Request $request, Book $book)
    {
        $owns = $request->user()->purchasedBooks()->whereKey($book->id)->exists();
        abort_unless($owns, 403);

        return response()->json($book);
    }
}
