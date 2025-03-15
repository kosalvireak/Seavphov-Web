<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'owner_id',
        'body',
        'image', // Not Optional field, but i intentionally set to null if user does not upload an image
        'comments',
        'like',
        'dislike',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id')->select(['name', 'picture', 'uuid'])->get();
    }

    public function getData($userId = null, $truncate = false)
    {
        $deleteAble = $userId == null ? false : $userId == $this->owner_id;

        $body = $truncate ? substr($this->body, 0, 255)  : $this->body;
        return [
            'id' => $this->id,
            'user' => $this->owner(),
            'body' => $body,
            'has_more_text' => $this->body != $body,
            'image' => $this->image,
            'number_of_comments' => $this->comments,
            'like' => $this->like,
            'dislike' => $this->dislike,
            'reaction' => $this->getUserReaction($userId),
            'delete_able' => $deleteAble,
            'created_at' => $this->created_at
        ];
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
        $discussionReaction = Reaction::where('entity_id', $this->id)
            ->where('user_id', $userId)
            ->where('entity_type', 'discussion')
            ->first();
        return $discussionReaction != null ? $discussionReaction->getReactionAsBoolean() : null;
    }
}
