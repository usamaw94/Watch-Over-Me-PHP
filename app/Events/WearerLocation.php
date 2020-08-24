<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WearerLocation implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $serviceId;
    public $locationLatitude;
    public $locationLongitude;
    public $locality;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userId,$serviceId,$locationLatitude,$locationLongitude,$locality)
    {
        $this->userId = $userId;
        $this->serviceId = $serviceId;
        $this->locationLatitude = $locationLatitude;
        $this->locationLongitude = $locationLongitude;
        $this->locality = $locality;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('location.'.$this->serviceId.".".$this->userId);
    }

    public function broadcastWith() {
        return [
            'userId' => $this->userId,
            'serviceId' => $this->serviceId,
            'locationLatitude' => $this->locationLatitude,
            'locationLongitude' => $this->locationLongitude,
            'locality' => $this->locality
        ];
    }
}
