<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PrintDC extends Job implements SelfHandling,ShouldQueue
{
    use InteractsWithQueue,SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $dc_number="";
    private $dc_file="";
    public function __construct($dc_number,$dc_file)
    {
        $this->dc_number=$dc_number;
        $this->dc_file=$dc_file;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $command = '/usr/local/bin/wkhtmltopdf -q --copies 3 "localhost:8000/dc/printDC?dc_number=' . $this->dc_number . '&print=2"  "/Applications/projects/trackingsystem/public/storage/'.$this->dc_file.'.pdf" ' . '  > /dev/null 2>&1 &';
        exec($command, $outputArray);
        //
    }
}
