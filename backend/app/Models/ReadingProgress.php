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

    public function readingChallenge()
    {
        return $this->belongsTo(ReadingChallenge::class, 'reading_challenge_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->first();
    }

    public function getData()
    {
        $user = $this->user();
        return [
            'progress' => $this->progress,
            'uuid' => $user->uuid,
            'name' => $user->name,
            'picture' => $user->picture,
        ];
    }
}