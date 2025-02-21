<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'entity_id',
        'reaction',
        'entity_type' // 'review', 'comment', 'discussion'
        // true = like ; unlike = false, like = true
        // false = unlike ; unlike = true, like = false
        // null = no reaction;  unlike = false , like = false,

        // Like()
        // 	if(exist)
        // 		is like -> delete
        // 		is dislike -> like
        // 	else
        // 		create new -> like
        // Unlike()
        // 	if(exist)
        // 		is like -> dislike
        // 		is dislike -> delete
        // 	else
        // 		create new -> dislike
    ];

    public static function getFirstReview($reviewId, $userId)
    {
        return self::where('entity_id', $reviewId)
            ->where('user_id', $userId)
            ->where('entity_type', 'review')
            ->first();
    }

    public function getReaction()
    {
        if ($this->reaction == null) {
            return null;
        } else if ($this->reaction == 1) {
            return true;
        }
        return false;
    }
}
