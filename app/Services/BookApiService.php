<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BookApiService
{
    private string $baseUrl = "https://openlibrary.org";

    /**
     * Buscar libros en OpenLibrary.
     */
    public function search(string $query): array
    {
        $query = urlencode($query);

        $response = Http::get("{$this->baseUrl}/search.json?q={$query}");

        return $response->json()['docs'] ?? [];
    }

    /**
     * Obtener detalles generales de un libro usando su Work ID.
     * Solo metadata. No contenido.
     */
    public function details(string $workId): array
    {
        $response = Http::get("{$this->baseUrl}/works/{$workId}.json");

        return $response->json() ?? [];
    }
}
