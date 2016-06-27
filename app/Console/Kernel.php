<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Event;
use Log ;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\SoFetch::class,
        \App\Console\Commands\locationPoll::class,
        \App\Console\Commands\notificationAutomatic::class,
        \App\Console\Commands\getBEBBNos::class,
        \App\Console\Commands\pullPO::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('inspire')->hourly();
        $schedule->command('navision:pullSO')
				->cron('*/10 * * * *')
				->withoutOverlapping();
        Log::info("Nav task run \n");

        $schedule->command('cron:all')
            ->cron('*/7 * * * *')
            ->withoutOverlapping();

        $schedule->command('notify:automaticReport')
            ->cron('00 00 * * *')
            ->withoutOverlapping();

        $schedule->command('navision:getBEBBNos')
            ->daily()
            ->withoutOverlapping();


    }
}
