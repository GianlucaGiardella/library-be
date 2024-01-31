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
                'id' => $user_book['id'],
                'readings' => $user_book['readings'],
                'added_at' => $user_book['added_at'],
                'deleted_at' => $user_book['deleted_at'],
            ]);
        }
    }
}
