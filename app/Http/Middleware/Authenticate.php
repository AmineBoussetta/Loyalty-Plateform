<?php

namespace App\Http\Middleware;
use Closure;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (auth()->user() && auth()->user()->role == 1) {
            return $next($request);
        }

        return redirect('/');
    }
}
