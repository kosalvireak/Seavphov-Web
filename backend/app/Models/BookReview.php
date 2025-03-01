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
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function increaseLike()
    {
        $this->like += 1;
        $this->save();
    }
    public function decreaseLike()
    {
        if ($this->like == 0) {
            $this->like = 0;
        } else {
            $this->like -= 1;
        }
        $this->save();
    }
    public function increaseDislike()
    {
        $this->dislike += 1;
        $this->save();
    }
    public function decreaseDislike()
    {
        if ($this->dislike == 0) {
            $this->dislike = 0;
        } else {
            $this->dislike -= 1;
        }
        $this->save();
    }
    private function getUserReaction($userId = null)
    {
        if ($userId == null) return null;
        $reviewReaction = Reaction::where('entity_id', $this->id)
            ->where('user_id', $userId)
            ->where('entity_type', 'review')
            ->first();
        return $reviewReaction != null ? $reviewReaction->getReactionAsBoolean() : null;
    }

    public function getData($userId = null)
    {
        $deleteAble = $userId == null ? false : $userId == $this->user_id;
        return [
            'id' => $this->id,
            'user' => $this->owner(),
            'body' => $this->body,
            'reaction' => $this->getUserReaction($userId),
            'like' => $this->like,
            'dislike' => $this->dislike,
            'delete_able' => $deleteAble,
            'created_at' => $this->created_at
        ];
    }

    public function getMyReview($userId)
    {
        $book = Book::where('id', $this->book_id)->first();

        return [
            'id' => $this->id,
            'user' => $this->owner(),
            'body' => $this->body,
            'reaction' => $this->getUserReaction($userId),
            'like' => $this->like,
            'dislike' => $this->dislike,
            'delete_able' => true,
            'created_at' => $this->created_at,
            'bookId' => $book->id,
            'bookTitle' => $book->title,
            'bookImages' => $book->images
        ];
    }
}
