<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class DatabaseController extends Controller {

    /**
     * GET /database/item/{id}
     */
    public function item($id)
    {
        $key = 'item_'.$id.'_'.Cookie::get('language');

        if(Cache::has($key)){
            echo Cache::get($key);
        }
        elseif(config('aion.aion_version') == '2.7') {
            
            $value = file_get_contents('https://aiondatabase.info/'.Cookie::get('language').'/tip/'.$id);
            $value = str_replace('src="/', 'src="https://aiondatabase.info/', $value);
            
        } else {

            $value = file_get_contents('http://aiondatabase.net/tip.php?id=item--'.$id.'&l='.Cookie::get('language').'&nf=on');
            $value = str_replace('src="/', 'src="http://aiondatabase.net/', $value);

            Cache::forever($key, $value);

            echo $value;
        }
    }

}
