<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewReaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'review_id',
        'user_id',
        'reaction',
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
