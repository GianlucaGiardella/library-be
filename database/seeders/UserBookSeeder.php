<?php

namespace Database\Seeders;

use App\Models\UserBook;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserBookSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('library.user_book') as $user_book) {
            UserBook::create([
                'user_id' => $user_book['user_id'],
                'book_id' => $user_book['book_id'],
                'added_at' => $user_book['added_at'],
                'deleted_at' => $user_book['deleted_at'],
            ]);
        }
    }
}