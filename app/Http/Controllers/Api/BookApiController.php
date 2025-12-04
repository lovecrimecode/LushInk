<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookApiController extends Controller
{
    public function index() {
        return Book::select('id, title, author, cover, description')->get();
    }

    public function show(Book $book) {
        return $book;
    }

    public function search (Request $request) {
        $query = urlemcode($request->input('q'));

        $response = Http::get(("https://openlibrary.org/search.json?q={$query}");

        return $responde->json()['docs'] ?? [];
    }

    public function details($workId) {
        $response = Http::get("https://openlibrary.org/works/{$workId}.json");

        return $response->json() ?? [];
    }

    public function read($editionId) {
        $response = Http::get("https://openlibrary.org/books/{$editionId}.json");

        if (isset($edition['formats']['text/html'])) {
            $htmlUrl = $edition['formats']['text/html'];
            $response = Http::get($htmlUrl);
            return $response->body();
        }

        if (isset($edition['formats']['text/plain'])) {
            $htmlUrl = $edition['formats']['text/plain'];
            $response = Http::get($htmlUrl);
            return $response->body();
        }

        return "Content not available in reading format.";
    }
}
