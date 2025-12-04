<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'title' => 'Sample Book',
            'author' => 'Author Name',
            'cover' => 'https://...',
            'description' => 'This is a sample book description.',
            'content' => 'Lorem ipsum...'
        ]);
    }
}
