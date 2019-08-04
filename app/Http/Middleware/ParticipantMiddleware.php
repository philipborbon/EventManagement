<?php

namespace EventManagement\Http\Middleware;

use Closure;

class ParticipantMiddleware
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
        if ($request->user() && $request->user()->usertype != 'participant') {
            return response(view('unauthorized')->with('role', 'Participants'));
        }

        return $next($request);
    }
}
