<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function reactions($userId): HasMany
    {
        return $this->hasMany(Reaction::class, 'entity_id')
            ->where('entity_type', 'review')
            ->where('user_id', $userId);
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
        $reaction = $this->reactions($userId)->first();
        return $reaction != null ? $reaction->getReactionAsBoolean() : null;
    }

    public function getData($userId = null, $bookOwnerId = null)
    {
        $isReviewOwner = $userId && $userId == $this->user_id;
        $isBookOwner = $userId && $userId == $bookOwnerId;

        return [
            'id' => $this->id,
            'user' => $this->owner(),
            'body' => $this->body,
            'reaction' => $this->getUserReaction($userId),
            'like' => $this->like,
            'dislike' => $this->dislike,
            'edit_able' => $isReviewOwner,
            'delete_able' => $isReviewOwner || $isBookOwner,
            'created_at' => $this->created_at
        ];
    }

    public function getMyReview($userId)
    {
        $book = $this->book;

        return [
            'id' => $this->id,
            'user' => $this->owner(),
            'body' => $this->body,
            'reaction' => $this->getUserReaction($userId),
            'like' => $this->like,
            'dislike' => $this->dislike,
            'delete_able' => true,
            'edit_able' => true,
            'created_at' => $this->created_at,
            'bookId' => $book->id,
            'bookTitle' => $book->title,
            'bookImages' => $book->images
        ];
    }
}
