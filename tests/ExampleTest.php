<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    function setUp(){
        @session_start();
        parent::setUp();
//        Session::setDefaultDriver('array');
//        $this->manager = app('session');
//
//        $user = \Illuminate\Support\Facades\DB::table('users')->where('user_id_ish', 'user-identifier')->first();
//        \Illuminate\Support\Facades\Auth::setUser($user);
    }
    public function testBasicExample()
    {
        //@session_start();
//        $base_url = config('app.rewrite_base');
        $this->visit('home')
            ->visit('reports')
            ->press('so');
//            ->type('BI00515','username')
//            ->type('123456','password');
//            ->press('login');
//             ->see('Laravel 5');
    }
}
