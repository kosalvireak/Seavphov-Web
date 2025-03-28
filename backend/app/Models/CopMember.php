<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CopMember extends Model
{

    protected $table = 'cop_members';

    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'cop_id',
        'role', // 1 for admin, 2 for member
    ];

    public function community()
    {
        return $this->belongsTo(Community::class, 'cop_id');
    }
}
