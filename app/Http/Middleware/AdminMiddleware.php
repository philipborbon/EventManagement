<?php

namespace EventManagement\Http\Middleware;

use Closure;

class AdminMiddleware
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
        if ($request->user() && $request->user()->usertype != 'admin') {
            return response(view('unauthorized')->with('role', 'ADMIN'));
        }

        return $next($request);
    }
}
