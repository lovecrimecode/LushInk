<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function index(): RedirectResponse
    {
        return redirect()->route('book.search');
    }

    public function search(Request $request)
    {
        $q = (string) $request->query('q', '');

        return view('search', compact('q'));
    }

    public function show(string $id)
    {
        return view('details', ['id' => $id]);
    }

    public function library()
    {
        return view('library');
    }
}
