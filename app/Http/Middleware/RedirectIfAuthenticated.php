<?php

namespace sisco\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string|null  $guard
   * @return mixed
   */
  public function handle($request, Closure $next, $guard = null)
  {

    if (!$request->is('login') && Auth::guard($guard)->check()
	    && !$request->is('register')) 
    {
      return redirect()->back();
    }

    return $next($request);




      // if (Auth::guard($guard)->check()) {
      //     return redirect('/home');
      // }

      // return $next($request);
  }
}
