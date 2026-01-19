<?php

namespace App\Services;

use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Cache; 
use Illuminate\Support\Facades\Log;

//Transforma la llamada a la API externa en datos útiles para la aplicación
class BookApiService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.openlibrary.base_url', 'https://openlibrary.org'), '/');
    }
   
    public function index(): array
    {
            try {
                $res = Http::timeout(10)
                    ->retry(2, 200)
                    ->get("{$this->baseUrl}/trending/now.json");

                if (!$res->successful()) return [];

                $works = $res->json('works', []);

                return collect($works)->take(20)->map(function ($d) {
                    $workKey = $d['key'] ?? '';
                    $workId = str_starts_with($workKey, '/works/')
                        ? substr($workKey, 7)
                        : $workKey;

                    $coverId = $d['cover_i'] ?? null;
                    $coverUrl = $coverId ? "https://covers.openlibrary.org/b/id/{$coverId}-M.jpg" : null;

                    return [
                        'work_id' => $workId,
                        'title' => $d['title'] ?? 'Untitled',
                        'author' => $d['author_name'][0] ?? null,
                        'published_year' => $d['first_publish_year'] ?? null,
                        'cover_url' => $coverUrl,
                    ];
                })->values()->all();
            } catch (\Exception $e) {
                Log::error("Error al consumir OpenLibrary", ['error' => $e->getMessage()]);
                return [];
            }
    }

    public function search(string $query): array
    {
        $query = trim($query);
        if ($query === '') return [];

        $res = Http::timeout(15)
            ->retry(2, 200)
            ->get("{$this->baseUrl}/search.json", [
                'q' => $query,
            ]);

        if (!$res->successful()) return [];

        $docs = $res->json('docs', []);

        // Normaliza para la UI
        return collect($docs)->take(20)->map(function ($d) {
            $workKey = $d['key'] ?? '';
            $workId = str_starts_with($workKey, '/works/')
                ? substr($workKey, 7)
                : $workKey;

            $coverId = $d['cover_i'] ?? null;
            $coverUrl = $coverId ? "https://covers.openlibrary.org/b/id/{$coverId}-M.jpg" : null;

            return [
                'work_id' => $workId,
                'title' => $d['title'] ?? 'Untitled',
                'author' => $d['author_name'][0] ?? null,
                'published_year' => $d['first_publish_year'] ?? null,
                'cover_url' => $coverUrl,
            ];
        })->values()->all();
    }

    public function details(string $workId): array
    {
        $workId = trim($workId);
        if ($workId === '') return [];

        $res = Http::timeout(15)
            ->retry(2, 200)
            ->get("{$this->baseUrl}/works/{$workId}.json");

        if (!$res->successful()) return [];

        $work = $res->json();

        $desc = $work['description'] ?? null;
        $description = is_array($desc) ? ($desc['value'] ?? null) : $desc;

        $covers = $work['covers'] ?? [];
        $coverUrl = !empty($covers)
            ? "https://covers.openlibrary.org/b/id/{$covers[0]}-L.jpg"
            : null;

        return [
            'work_id' => $workId,
            'title' => $work['title'] ?? null,
            'description' => $description,
            'cover_url' => $coverUrl,
            'subjects' => array_slice($work['subjects'] ?? [], 0, 10),
        ];
    }
}
