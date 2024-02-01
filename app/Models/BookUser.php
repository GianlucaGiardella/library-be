<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BookUser extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'readings',
        'added_at',
        'deleted_at',
    ];

    public $timestamps = false;

    protected $table = 'book_user';
}
