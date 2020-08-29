<?php

namespace App\Events;

use App\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use PhpParser\Node\Scalar\String_;

class NewAlertLog implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $serviceId;
    public $wearerId;
    public $wearerName;
    public $watcherId;
    public $respondingLink;
    public $createdAt;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($serviceId, $wearerId, $wearerName, $watcherId, $respondingLink, $createdAt)
    {
        $this->serviceId = $serviceId;
        $this->wearerId = $wearerId;
        $this->wearerName = $wearerName;
        $this->watcherId = $watcherId;
        $this->respondingLink = $respondingLink;
        $this->createdAt = $createdAt;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('notifyAlertLog.'.$this->watcherId);
    }

    public function broadcastWith() {
        return [
            'serviceId' => $this->serviceId,
            'wearerId' => $this->wearerId,
            'wearerName' => $this->wearerName,
            'watcherId' => $this->watcherId,
            'respondingLink' => $this->respondingLink,
            'created_at' => $this->createdAt
        ];
    }
}
