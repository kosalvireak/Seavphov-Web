<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingProgress extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'progress',
        'reading_challenge_id',
    ];
}
