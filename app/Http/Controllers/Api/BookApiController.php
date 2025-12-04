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
}
