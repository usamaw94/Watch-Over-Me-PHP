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
    public $responderName;
    public $responderId;
    public $response;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($serviceId, $logId,$responderId,$responderName,$response)
    {
        $this->serviceId = $serviceId;
        $this->logId = $logId;
        $this->responderId = $responderId;
        $this->responderName = $responderName;
        $this->response = $response;
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
            'logId' => $this->logId,
            'responderId' => $this->responderId,
            'responderName' => $this->responderName,
            'response' => $this->response
        ];
    }
}
