<?php

namespace App\Listeners;

use App\Models\LogActivity;
use App\Events\UserActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserActivity implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserActivity $event)
    {
        $log = new LogActivity();
        $log->subject = $event->subject;
        $log->url = $event->url;
        $log->method = $event->method;
        $log->ip = $event->ip;
        $log->agent = $event->agent;
        $log->user_id = $event->user_id;
        $log->save();
    }
}
