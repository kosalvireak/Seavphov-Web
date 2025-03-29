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

    public function getNotificationObjectId()
    {
        if ($this->isCopNotification()) {
            $cop = Community::find($this->object_id);
            return $cop != null ? $cop->route : null;
        } else {
            return $this->object_id;
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
}
