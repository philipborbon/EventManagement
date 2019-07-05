<?php

namespace EventManagement\Http\Middleware;

use Closure;

class EmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->usertype != 'employee' && $request->user()->usertype != 'admin' ) {
            return response(view('unauthorized')->with('role', 'Employees'));
        }

        return $next($request);
    }
}
