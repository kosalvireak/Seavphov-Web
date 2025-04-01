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

    public function getObjectImage()
    {
        if ($this->type == 'book') {
            $book = Book::find($this->object_id);
            return $book != null ? $book->images : $this->getImageNotFound();
        } else if ($this->type == 'discussion') {
            $discussion = Discussion::find($this->object_id);
            return $discussion != null ? $discussion->image : $this->getImageNotFound();
        } else if ($this->isCopNotification()) {
            $cop = Community::find($this->object_id);
            return $cop != null ? $cop->profile : $this->getImageNotFound();
        }
    }

    public function getNotificationUrl()
    {
        if ($this->type == "book" || $this->type == "discussion") {
            return "/" . $this->type . "/" . $this->object_id;
        } else if ($this->isCopNotification()) {
            return $this->getCopNotificationUrl();
        } else {
            return null;
        }
    }

    private function getCopNotificationUrl(): string
    {
        $cop = Community::find($this->object_id);
        switch ($this->type) {
            case 'request-to-join-cop':
                return "/community/" . $cop->route . "/members#tabs=member-requests";

            case 'join-cop':
                return "/community/" . $cop->route . "/members";

            case 'approve-cop-join-request':
            case 'reject-cop-join-request':
                return "/community/" . $cop->route;

            default:
                return "";
        }
    }

    private function isCopNotification(): bool
    {
        return in_array($this->type, [
            'request-to-join-cop',
            'approve-cop-join-request',
            'reject-cop-join-request',
            'join-cop'
        ]);
    }


    private function getImageNotFound(): string
    {
        return 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
