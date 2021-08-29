<?php namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;

class Language {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if we have this language
        foreach(Config::get('aion.languages') as $language) {

            if(Cookie::has('language')){
                if(Cookie::get('language') === $language){
                    App::setLocale(Cookie::get('language'));
                    Carbon::setLocale(Cookie::get('language'));
                }
            }

        }

        return $next($request);
    }

}
