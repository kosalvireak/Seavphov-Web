<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

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


    public function getData($userId = null)
    {
        $isOwner = $userId == null ? false : $userId == $this->user_id;
        return [
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'total_member' => $this->total_member,
            'description' => $this->description,
            'book_image' => $this->book_image,
            'book_title' => $this->book_title,
            'book_author' => $this->book_author,
            'is_owner' => $isOwner,
            'owner' => $this->owner()
        ];
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id')->select(['name', 'picture', 'uuid'])->first();
    }

    public function cop()
    {
        return $this->belongsTo(Community::class, 'cop_id');
    }

    public function getAllProgress()
    {
        return $this->hasMany(ReadingProgress::class, 'reading_challenge_id')
            ->orderBy('progress', 'desc')
            ->orderBy('updated_at', 'asc')
            ->get();
    }
}
