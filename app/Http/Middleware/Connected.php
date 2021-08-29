<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class Connected {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if(!Session::has('connected')){
            return redirect(route('home'))->with('error', Lang::get('flashMessage.user.connected'));
        }

		return $next($request);
	}

}
