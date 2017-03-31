<?php

namespace App\Providers;

use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Queue::after(function ($connection, $job, $data) {
//            $job=json_decode($job);
//            dd($job);
            Log::info('connection:'.$connection);
//            dd($job);
//            Log::info("success");
            echo "connection:".$connection;
        });
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
