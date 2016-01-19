<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class ActivityLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $vtiger_user = Session::get('vt_user');
        $action_log = new \App\action_log();
        $action_log->vtiger_id = $vtiger_user;
        $action_log->action = $request->path();
        $action_log->parameter_string = serialize($request->all());
        $action_log->method = $request->method();
        $action_log->save();

        return $next($request);
    }
}


