<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Community extends Model
{
    use HasFactory;

    // Define default banner and profile image URLs
    const DEFAULT_BANNER = 'https://charitysmith.org/wp-content/uploads/2023/09/community.webp';
    const DEFAULT_PROFILE = 'https://static.vecteezy.com/system/resources/previews/054/453/530/non_2x/proactive-community-engagement-icon-vector.jpg';

    protected $casts = [
        'private' => 'boolean', // Explicitly cast 'is_active' to boolean
    ];

    protected $fillable = [
        'id',
        'name',
        'route',
        'profile',
        'banner',
        'description',
        'private',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($community) {
            // Set default banner if not provided
            if (empty($community->banner)) {
                $community->banner = self::DEFAULT_BANNER;
            }
        });
    }

    public static function defaultBanner()
    {
        return self::DEFAULT_BANNER;
    }

    public static function generateSlug($copName)
    {
        return Str::slug($copName, '-');
    }

    public function getData()
    {
        return [
            'name' => $this->name,
            'route' => $this->route,
            'profile' => $this->profile,
            'banner' => $this->banner,
            'description' => $this->description,
            'private' => $this->private,
        ];
    }
}
