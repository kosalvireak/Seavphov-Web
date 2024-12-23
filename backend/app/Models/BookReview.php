<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookReview extends Model
{
    use HasFactory;
    
    protected $fillable = [
    'id',
    'user_id',
    'book_id',
    'body',
    'helpful_vote',
    'not_helpful_vote',
    ];

    public function owner(){
        $user = $this->belongsTo(User::class, 'user_id')->first();
        $user->get([ 'name','uuid','picture']);
        return $user;
    }
}