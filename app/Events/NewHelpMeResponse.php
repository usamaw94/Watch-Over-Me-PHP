<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewHelpMeResponse implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $serviceId;
    public $logId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($serviceId, $logId)
    {
        $this->serviceId = $serviceId;
        $this->logId = $logId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('help-me-response.'.$this->serviceId.".".$this->logId);
    }

    public function broadcastWith() {
        return [
            'serviceId' => $this->serviceId,
            'logId' => $this->logId
        ];
    }
}
