<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'add_date',
        'delete_date',
    ];

    protected $table = 'user_book';
}
