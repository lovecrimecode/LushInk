<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BookApiService
{
    private string $baseUrl = "https://openlibrary.org";

    /**
     * Buscar libros por título, autor, palabra clave.
     */
    public function search(string $query): array
    {
        $query = urlencode($query);

        $response = Http::get("{$this->baseUrl}/search.json?q={$query}");

        return $response->json()['docs'] ?? [];
    }

    /**
     * Obtener detalles de un libro usando el Work ID.
     */
    public function details(string $workId): array
    {
        $response = Http::get("{$this->baseUrl}/works/{$workId}.json");

        return $response->json() ?? [];
    }

    // /**
    //  * Obtener la edición de un libro para encontrar formatos.
    //  */
    // public function edition(string $editionId): array
    // {
    //     $response = Http::get("{$this->baseUrl}/books/{$editionId}.json");

    //     return $response->json() ?? [];
    // }

    // /**
    //  * Devolver contenido legible (si existe).
    //  */
    // public function getReadableContent(string $editionId): string
    // {
    //     $edition = $this->edition($editionId);

    //     if (!$edition) return "Edition not found.";

    //     // HTML
    //     if (isset($edition['formats']['text/html'])) {
    //         $html = Http::get($edition['formats']['text/html']);
    //         return $html->body();
    //     }

    //     // Plain text
    //     if (isset($edition['formats']['text/plain'])) {
    //         $text = Http::get($edition['formats']['text/plain']);
    //         return nl2br($text->body());
    //     }

    //     return "Readable content not available for this edition.";
    // }
}
