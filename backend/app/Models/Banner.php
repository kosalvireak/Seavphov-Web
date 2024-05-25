<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_url',
        'link_url',
        'order_priority',
    ];

    public function resetAllColumns(){
        return self::update([
            'order_priority' => 0,
        ]);
    }
}