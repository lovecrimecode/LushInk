<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class ApiLibraryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $books = $user->purchasedBooks()
            ->with(['readingProgress' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->latest('purchases.created_at')
            ->get()
            ->map(function (Book $book) {
                $progress = $book->readingProgress->first();

                return [
                    'id' => $book->id,
                    'api_id' => $book->api_id,
                    'title' => $book->title,
                    'author' => $book->author,
                    'cover_url' => $book->cover,
                    'description' => $book->description,
                    'file_path' => $book->file_path,
                    'price' => (float) ($book->pivot->price ?? 0),
                    'progress' => [
                        'current_page' => $progress?->current_page ?? 0,
                        'total_pages' => $progress?->total_pages ?? 0,
                        'percentage_completed' => $progress?->percentage_completed ?? 0,
                    ],
                ];
            });

        return response()->json($books);
    }

    public function show(Request $request, Book $book)
    {
        $owns = $request->user()->purchasedBooks()->whereKey($book->id)->exists();
        abort_unless($owns, 403);

        return response()->json($book);
    }
}