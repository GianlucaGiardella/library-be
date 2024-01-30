<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('library.books') as $book) {
            Book::create([
                'id' => $book['id'],
                'title' => $book['title'],
                'author_id' => $book['author_id'],
                'isbn_code' => $book['isbn_code'],
                'added_at' => $book['added_at'],
                'deleted_at' => $book['deleted_at'],
                'plot' => $book['plot'],
                'readings' => $book['readings'],
            ]);
        }
    }
}