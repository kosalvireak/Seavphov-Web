<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'discussion_id',
        'owner_id',
        'body',
        'like',
        'dislike',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id')->select(['name', 'picture', 'uuid'])->get();
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
        if ($userId == null) {
            return null;
        }

        return optional(Reaction::where('entity_type', 'comment')
            ->where('entity_id', $this->id)
            ->where('user_id', $userId)
            ->first())->getReactionAsBoolean();
    }

    public function getData($userId = null)
    {
        $deleteAble = $userId == null ? false : $userId == $this->owner_id;
        return [
            'id' => $this->id,
            'user' => $this->owner(),
            'body' => $this->body,
            'reaction' => $this->getUserReaction($userId),
            'like' => $this->like,
            'dislike' => $this->dislike,
            'delete_able' => $deleteAble,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
