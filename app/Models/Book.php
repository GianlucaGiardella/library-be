<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author_id',
        'isbn_code',
        'plot',
        'readings',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
