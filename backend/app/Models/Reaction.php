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

    public static function  getFirstReactionByEntity($entityId,  $userId, $entityType)
    {
        $validType = ['review', 'comment', 'discussion'];
        if ($entityType != null && !in_array($entityType, $validType)) return null;

        return self::where('entity_id', $entityId)
            ->where('user_id', $userId)
            ->where('entity_type', $entityType)
            ->first();
    }

    public function getReactionAsBoolean()
    {
        return $this->reaction == 1 ? true : false;
    }
}
