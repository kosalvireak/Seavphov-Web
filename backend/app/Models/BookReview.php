<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'book_id',
        'user_id',
        'body',
        'like',
        'dislike',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id')->select(['name', 'picture', 'uuid'])->get();
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'user_id');
    }

    public function getData($userId = null)
    {
        $deleteAble = $userId == null ? false : $userId == $this->user_id;
        return [
            'id' => $this->id,
            'user' => $this->owner(),
            'body' => $this->body,
            'like' => $this->like,
            'dislike' => $this->dislike,
            'delete_able' => $deleteAble,
            'created_at' => $this->created_at
        ];
    }
}
