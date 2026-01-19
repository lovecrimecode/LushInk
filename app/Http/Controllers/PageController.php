<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function index()
    {
        // Solo devuelve la vista
        return view('book.index');
    }

    public function search(Request $request)
    {
        // Solo devuelve la vista 
        $q = (string) $request->query('q', '');
        return view('search', compact('q'));
    }

    public function details(string $id)
    {
        // Solo devuelve la vista con el id
        return view('details', ['id' => $id]);
    }

    public function library()
    {
        // Vista (los datos se cargan con fetch a tu API)
        return view('library');
    }
}
