<?php

namespace App\Jobs;

use App\Http\Controllers\notifications;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMail extends Job implements ShouldQueue
{
    use InteractsWithQueue,SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $dc_number="";
    private $email_id="";
    public function __construct($dc_number,$email_id)
    {
        $this->dc_number=$dc_number;
        $this->email_id=$email_id;

        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //dd($this->dc_number.$this->email_id);
        $mailDC = new notifications();
        return 1;
        //$mailDC->sendMail($this->dc_number, $this->email_id);
        //
    }
}
