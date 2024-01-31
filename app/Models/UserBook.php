<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'readings',
        'added_at',
        'deleted_at',
    ];

    protected $table = 'user_book';
}
