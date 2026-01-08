<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BookApiService;

class ApiBookController extends Controller
{
    public function __construct(
        private readonly BookApiService $api) {}

    public function search(Request $request)
    {
        $q = (string) $request->query('q', '');
        return response()->json($this->api->search($q));
    }

    public function details(string $id)
    {
        return response()->json($this->api->details($id));
    }

}
