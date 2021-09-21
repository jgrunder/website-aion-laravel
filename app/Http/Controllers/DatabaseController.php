<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class DatabaseController extends Controller {

    /**
     * GET /database/item/{id}
     */
    public function item($id)
    {
        $key = 'item_'.$id.'_'.$this->language;

        if(Cache::has($key)){
            echo Cache::get($key);
        }
        else {
            
            if(config('aion.aion_version') == '2.7') {
                
                $value = file_get_contents('https://aiondatabase.info/'.$this->language.'/tip/'.$id);
                $value = str_replace('src="/', 'src="https://aiondatabase.info/', $value);
                
            } else {
                
                $value = file_get_contents('http://aiondatabase.net/tip.php?id=item--'.$id.'&l='.$this->language.'&nf=on');
                $value = str_replace('src="/', 'src="http://aiondatabase.net/', $value);
                
            }
            
            Cache::forever($key, $value);
            echo $value;
        }
            
    }

}
