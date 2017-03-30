<?php

namespace App\Events;

use App\Events\Event;
use App\Http\Controllers\notifications;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Email extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($dc_number,$email_id)
    {
         $mailDC = new notifications();
         $mailDC->sendMail($dc_number, $email_id);

        //
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
