<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class Admin {

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {

    if(Session::get('user.access_level') < Config::get('aion.minimumAccessLevel')){
      return redirect(route('home'))->with('error', Lang::get('flashMessage.user.not_access_level'));
    }

    return $next($request);
  }

}
