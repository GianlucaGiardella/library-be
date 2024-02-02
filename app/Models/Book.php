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
        'author',
        'isbn_code',
        'plot',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('readings');
    }
}
