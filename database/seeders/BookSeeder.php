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
                'author' => $book['author'],
                'isbn_code' => $book['isbn_code'],
                'plot' => $book['plot'],
            ]);
        }
    }
}
