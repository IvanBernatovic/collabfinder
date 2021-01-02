<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SocialLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!in_array($request->service, ['twitter', 'google', 'github'])) {
            return abort(404, 'Driver not found');
        }

        return $next($request);
    }
}
