<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\Finder\Exception\ShellCommandFailureException;

class PrintDC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'print:DC';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $redis = new Redis('tcp://0.0.0.0:6379'."?read_write_timeout=-1&persistent=1");
        $redis::subscribe(['printDC'],function ($message){
            $json=json_decode($message);
            $dc_number=$json->dc_number;
            $dc_file=$json->dc_file;
            $command = '/usr/local/bin/wkhtmltopdf -q --copies 3 "localhost:8000/dc/printDC?dc_number=' . $dc_number . '&print=2"  "/Applications/projects/trackingsystem/public/storage/'.$dc_file.'.pdf" ' . '  > /dev/null 2>&1 &';
            exec($command, $outputArray);

        });

        //
    }
}
