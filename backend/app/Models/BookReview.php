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
    'helpful_vote',
    'not_helpful_vote',
    ];

     public function owner()
    {
        return $this->belongsTo(User::class, 'user_id')->select(['name', 'picture', 'uuid'])->get();
    }

    public function getData(){
        return [
            'id' => $this->id,
            'user' => $this->owner(),
            'body' => $this->body,
            'helpful_vote' => $this->helpful_vote,
            'not_helpful_vote' => $this->not_helpful_vote,
            'created_at' => $this->created_at
        ];
    }
}