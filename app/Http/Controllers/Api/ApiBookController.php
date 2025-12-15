<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BookApiService;

class ApiBookController extends Controller
{
    protected BookApiService $api;

    public function __construct(BookApiService $api)
    {
        $this->api = $api;
    }

    public function search(Request $request)
    {
        $query = $request->input('q', '');

        return $this->api->search($query);
    }

    public function details(string $id)
    {
        return $this->api->details($id);
    }

}
