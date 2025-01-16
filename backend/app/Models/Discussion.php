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
        'image',
        'comments',
        'helpful_vote',
        'not_helpful_vote',
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
            'helpful_vote' => $this->helpful_vote,
            'not_helpful_vote' => $this->not_helpful_vote,
            'delete_able' => $deleteAble,
            'created_at' => $this->created_at
        ];
    }
}