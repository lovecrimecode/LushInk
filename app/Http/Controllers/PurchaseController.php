<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function purchase(Request $request)
    {
        $validated = $request->validate([
            'api_id' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'cover' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $book = Book::firstOrCreate(
            ['api_id' => $validated['api_id']],
            [
                'title' => $validated['title'],
                'author' => $validated['author'] ?? 'Autor desconocido',
                'cover' => $validated['cover'] ?? null,
                'description' => $validated['description'] ?? null,
            ],
        );

        if ($book->wasRecentlyCreated === false) {
            $book->update([
                'title' => $validated['title'],
                'author' => $validated['author'] ?? $book->author,
                'cover' => $validated['cover'] ?? $book->cover,
                'description' => $validated['description'] ?? $book->description,
            ]);
        }

        $price = $validated['price'] ?? 0;

        $request->user()->purchasedBooks()->syncWithoutDetaching([
            $book->id => ['price' => $price],
        ]);

        return response()->json([
            'message' => 'Libro agregado a tu biblioteca.',
            'book' => $book,
        ]);
    }
}