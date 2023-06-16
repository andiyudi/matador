<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserActivity
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $subject;
    public $url;
    public $method;
    public $ip;
    public $agent;
    public $user_id;
    /**
     * Create a new event instance.
     */
    public function __construct($subject, $url, $method, $ip, $agent, $user_id)
    {
        $this->subject = $subject;
        $this->url = $url;
        $this->method = $method;
        $this->ip = $ip;
        $this->agent = $agent;
        $this->user_id = $user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
