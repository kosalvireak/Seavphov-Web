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
        'helpful_vote',
        'not_helpful_vote',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id')->select(['name', 'picture', 'uuid'])->get();
    }

    public function getData($userId = null)
    {
        $deleteAble = $userId == null ? false : $userId == $this->owner_id;
        return [
            'id' => $this->id,
            'user' => $this->owner(),
            'body' => $this->body,
            'helpful_vote' => $this->helpful_vote,
            'not_helpful_vote' => $this->not_helpful_vote,
            'delete_able' => $deleteAble,
            'created_at' => $this->created_at
        ];
    }
}