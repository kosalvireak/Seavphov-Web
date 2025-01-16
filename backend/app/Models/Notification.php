<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'receiver_id',
        'object_id',
        'type',
        'body',
    ];

    public function getObjectImage(){
        if($this->type == 'book'){
            return Book::Find($this->object_id)->images;
        }else if($this->type == 'discussion'){
            return Discussion::Find($this->object_id)->image;
        }
    }
}