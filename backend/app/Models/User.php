<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const DEFAULT_COVER_PHOTO = 'https://flowbite.com/docs/images/examples/image-3@2x.jpg';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->cover) || $user->cover === "null") {
                $user->cover = self::DEFAULT_COVER_PHOTO;
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cover',
        'bio',
        'picture',
        'phone',
        'instagram',
        'facebook',
        'twitter',
        'telegram',
        'location',
        'uuid'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'api_token_expires_at',
        'updated_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function generateToken()
    {
        $this->api_token = Str::random(60);
        $this->api_token_expires_at = now()->addDays(30);
        $this->save();

        return $this->api_token;
    }


    public function books()
    {
        return $this->hasMany(Book::class, 'owner_id');
    }

    public function book($id)
    {
        return $this->books()->where('id', $id)->first();
    }

    public function savedBooks()
    {
        return $this->belongsToMany(Book::class, 'book_user')->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'receiver_id');
    }
}
