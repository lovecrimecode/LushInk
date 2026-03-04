<?php

namespace Tests\Unit;

use App\Services\BookApiService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BookApiServiceTest extends TestCase
{
    public function test_empty_search_returns_books_from_index(): void
    {
        Http::fake([
            'https://openlibrary.org/trending/now.json' => Http::response([
                'works' => [
                    ['key' => '/works/OL1W', 'title' => 'Book A', 'author_name' => ['Author A'], 'first_publish_year' => 2001],
                    ['key' => '/works/OL2W', 'title' => 'Book B', 'author_name' => ['Author B'], 'first_publish_year' => 2002],
                    ['key' => '/works/OL3W', 'title' => 'Book C', 'author_name' => ['Author C'], 'first_publish_year' => 2003],
                ],
            ], 200),
        ]);

        $service = new BookApiService();

        $results = $service->search('');

        $this->assertCount(3, $results);
        $this->assertEqualsCanonicalizing(
            ['OL1W', 'OL2W', 'OL3W'],
            collect($results)->pluck('work_id')->all()
        );
    }
}
