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


    public function getData($userId = null)
    {
        $isOwner = $userId == null ? false : $userId == $this->user_id;
        return [
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'total_member' => $this->total_member,
            'description' => $this->description,
            'book_image' => $this->book_image,
            'book_title' => $this->book_title,
            'book_author' => $this->book_author,
            'is_owner' => $isOwner,
        ];
    }
}
