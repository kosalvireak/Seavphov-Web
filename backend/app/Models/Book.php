<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'condition',
        'categories',
        'images',
        'descriptions',
        'availability',
        'owner_id',
    ];

    public function owner()
    {
        $user = $this->belongsTo(User::class, 'owner_id')->first();
        $user->makeHidden([ 'email','api_token','remember_token']);
        return $user;
    }

    public function savedByUsers()
    {
        return DB::table('book_user')
            ->where('book_id', $this->id)
            ->get(['user_id', 'book_id','created_at']);
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function reviews(){
        return $this->hasMany(BookReview::class, 'book_id');
    }
}