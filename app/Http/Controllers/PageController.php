<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function search(Request $request)
    {
        $q = $request->input('q');

        $books = Http::get('http://127.0.0.1:8000/api/search', [
            'q' => $q
        ])->json();

        return view('search', compact('books', 'q'));
    }

    public function details($id)
    {
        $book = Http::get("http://127.0.0.1:8000/api/details/{$id}")->json();

        return view('details', compact('book'));
    }

    public function library(Request $request)
    {
        $books = Http::withHeaders([
            'Authorization' => 'Bearer ' . csrf_token()
        ])->get('http://127.0.0.1:8000/api/library')->json();

        return view('library', compact('books'));
    }
}
