<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ReadingProgress;
use Illuminate\Http\Request;

class ReadingProgressController extends Controller
{
    public function update(Request $request, Book $book)
    {
        $user = $request->user();

        $owns = $user->purchasedBooks()->whereKey($book->id)->exists();
        abort_unless($owns, 403, 'No tienes acceso a este libro.');

        $validated = $request->validate([
            'current_page' => ['nullable', 'integer', 'min:0'],
            'total_pages' => ['nullable', 'integer', 'min:1'],
        ]);

        $currentPage = (int) ($validated['current_page'] ?? 0);
        $totalPages = (int) ($validated['total_pages'] ?? 0);

        $percentage = $totalPages > 0
            ? min(100, round(($currentPage / $totalPages) * 100, 2))
            : 0;

        $progress = ReadingProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'book_id' => $book->id,
            ],
            [
                'current_page' => $currentPage,
                'total_pages' => $totalPages,
                'percentage_completed' => $percentage,
            ],
        );

        return response()->json([
            'message' => 'Progreso actualizado',
            'progress' => $progress,
        ]);
    }
}
