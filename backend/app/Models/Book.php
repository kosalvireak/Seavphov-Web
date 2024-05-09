<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $user->makeHidden([ 'email','api_token','remember_token','created_at']);
        return $user;
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class);
    }
}