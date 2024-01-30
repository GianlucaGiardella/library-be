<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('library.authors') as $author) {
            Author::create([
                'id' => $author['id'],
                'name' => $author['name'],
            ]);
        }
    }
}
