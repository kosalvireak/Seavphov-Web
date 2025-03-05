<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Community extends Model
{


    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'route',
        'profile',
        'banner',
        'description',
        'private',
    ];

    public static function defaultBanner()
    {
        return 'https://charitysmith.org/wp-content/uploads/2023/09/community.webp';
    }

    public static function defaultProfile()
    {
        return 'https://static.vecteezy.com/system/resources/previews/054/453/530/non_2x/proactive-community-engagement-icon-vector.jpg';
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
            'private' => $this->private == 0,
        ];
    }
}
