<?php

namespace App\Http\Middleware;

use Closure;

class Maintenance
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
        if(setting()->status == 'open') {
          return $next($request);
        } else {
          return redirect('maintenance');
        }
    }
}
