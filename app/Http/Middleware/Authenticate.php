<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Session;
class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Session::has('authenticated') || !Session::get('authenticated')) {

            $url = \URL::full();
            if($url)
            Session::set('redirectURL', \URL::full());
            else
                Session::set('redirectURL', "/");

            if ($request->ajax()) {
                return response()->json(array('auth_required' => true));
            } else {
                return redirect()->guest('auth/login');
            }
        }

        return $next($request);
    }
}
