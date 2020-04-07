<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class adminLogin
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
      if(empty(Session::has('adminSession'))) {
           return redirect('/admin')->with('flash_message_error','please login or register firest');
      }
        return $next($request);
    }
}
