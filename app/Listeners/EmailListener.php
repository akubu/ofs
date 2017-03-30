<?php

namespace App\Listeners;

use App\Events\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Email  $event
     * @return void
     */
    public function handle(Email $event)
    {

        //
    }

    public function failed(Email $event, $exception)
    {

        //
    }
}
