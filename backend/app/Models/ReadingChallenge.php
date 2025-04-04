<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingChallenge extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'cop_id',
        'total_member',
        'description',
        'book_image',
        'book_title',
        'book_author',
        'start_date',
        'end_date',
    ];
}
