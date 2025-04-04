<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    use HasFactory;

    protected $casts = [
        'has_pdf' => 'boolean', // Explicitly cast 'has_pdf' to boolean
    ];

    protected $fillable = [
        'title',
        'author',
        'condition',
        'categories',
        'images',
        'descriptions',
        'availability',
        'owner_id',
        'has_pdf',
        'pdf_url',
        'pdf_filename',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id')
            ->select([
                'id',
                'name',
                'picture',
                'uuid',
                'created_at',
                'phone',
                'location'
            ])
            ->first();
    }

    public function savedByUsers()
    {
        return DB::table('book_user')
            ->where('book_id', $this->id)
            ->get(['user_id', 'book_id', 'created_at']);
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function reviews()
    {
        return $this->hasMany(BookReview::class, 'book_id');
    }
}
