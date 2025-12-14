<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BookApiService;

class BookApiController extends Controller
{
    protected BookApiService $api;

    public function __construct(BookApiService $api)
    {
        $this->api = $api;
    }

    // Buscar libros por query
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        return $this->api->search($query);
    }

    // Ver detalles generales del libro
    public function details(string $id)
    {
        return $this->api->details($id);
    }
}
