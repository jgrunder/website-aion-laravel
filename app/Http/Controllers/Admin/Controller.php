<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

abstract class Controller extends BaseController {

    use ValidatesRequests;

    /**
     * @var $protected
     */
    protected $language;

    /**
     * Set global Variables for ALL view
     */
    public function __construct()
    {
        $this->serversTest();
        $this->getLanguageFromCookie();
        $this->adminLogsMenu();
    }

    /**
     * Set Variables $serversStatus
     */
    private function serversTest()
    {
        $servers        = Config::get('aion.servers');
        $serversStatus  = [];

        foreach ($servers as $key => $server) {

            if(Cache::has('status.'.$key)){
                $serversStatus[] = [
                    'name'   => $key,
                    'status' => Cache::get('status.'.$key)
                ];
            } else {
                $check = @fsockopen($server['ip'], $server['port'], $errno, $errstr, 1.0);

                $expiresAt = Carbon::now()->addMinutes(5);

                Cache::put('status.'.$key, ($check) ? true : false, $expiresAt);

                $serversStatus[] = [
                    'name'   => $key,
                    'status' => ($check) ? true : false
                ];

                @fclose($check);
            }

        }

        View::share('serversStatus', $serversStatus);
    }

    /**
     * Set variables $adminLogsMenu
     */
    private function adminLogsMenu()
    {
        if (Session::has('connected') && Session::get('user.access_level') > 0) {

            $logFiles  = Config::get('aion.logs.files');
            $logsMenu  = [];

            foreach ($logFiles as $key => $value){

                if(Session::get('user.access_level') >= $value['access_level']){
                    $logsMenu[] = $value['file'];
                }

            }

            View::share('adminLogsMenu', $logsMenu);

        }
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
    }

}
