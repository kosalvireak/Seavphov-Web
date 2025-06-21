<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendNotification implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message = "Hello from SendNotification";

    public function __construct(public User $user) {}

    public function broadcastOn()
    {
        // Use 'users' prefix to match your frontend channel name
        return new Channel('users.' . $this->user->uuid);

        // OR if using ID instead of UUID:
        // return new PrivateChannel('user.' . $this->user->id);
    }

    public function broadcastAs()
    {
        return 'SendNotification';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->user->id,
            'uuid' => $this->user->uuid,
            'message' => $this->message
        ];
    }
}
