<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function purchase(Request $request)
    {
        $validated = $request->validate([
            'api_id' => 'required',
            'title' => 'required',
            'author' => 'nullable',
            'cover_url' => 'nullable',
            'description' => 'nullable'
        ]);

        // Verificar si ya existe localmente
        $book = Book::firstOrCreate(
            ['api_id' => $validated['api_id']],
            $validated
        );

        // Asociar al usuario
        auth()->user()->purchasedBooks()->syncWithoutDetaching([$book->id]);

        return response()->json([
            'message' => 'Book purchased successfully',
            'book' => $book
        ]);
    }
}
