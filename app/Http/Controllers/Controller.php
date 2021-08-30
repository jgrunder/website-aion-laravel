<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * @var $protected
     */
    protected $language;
    
    /**
     * Set variables for all app
     */
    public function __construct()
    {
        $this->getLanguageFromCookie();
    }
    
    
    /**
     * Get Language from Cookie
     */
    private function getLanguageFromCookie()
    {
        if (Cookie::has('language')){
            $this->language = Cookie::get('language');
        } else {
            $this->language = 'fr';
        }
        App::setLocale($this->language);
    }
    
}
