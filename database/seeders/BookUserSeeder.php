<?php

namespace Database\Seeders;

use App\Models\BookUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookUserSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('library.book_user') as $book_user) {
            BookUser::create([
                'user_id' => $book_user['user_id'],
                'book_id' => $book_user['book_id'],
                'readings' => $book_user['readings'],
                'added_at' => $book_user['added_at'],
                'deleted_at' => $book_user['deleted_at'],
            ]);
        }
    }
}
