<?php

namespace App\Http\Controllers;

use App\Models\Gameserver\Player;
use App\Models\Webserver\News;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ApiController extends Controller {
    
    /**
     * GET /api/online
     */
    public function online()
    {
        return ['response' => [
            'player_count' => Player::online()->count(),
            'result' => 1,
        ]];
    }
    
    /**
     * GET /api/news
     */
    public function news()
    {
        $news = News::orderBy('created_at', 'DESC')->limit(4)->get();
        $data = '';
        foreach ($news as $new) {
            $data .= '&#8224; ' . $new->title . ' (<a href="' . route('news', [$new->slug, $new->id]) . '" target="_blank">' . Carbon::parse($new->created_at)->format('d/m/Y') . '</a>)<br/>';
        }
        return ['html' => $data];
    }
    
    /**
     * GET /api/lastnews
     */
    public function lastnews()
    {
        $new = News::orderBy('created_at', 'DESC')->first();
        $data = '<html><body><p><a href="' . route('news', [$new->slug, $new->id]) . '" target="_blank">' . htmlentities($new->title, 0, 'UTF-8') . '</a></p><hr/><p>';
        $data .= Str::replace(['<li>','</li>','<u>','</u>','<ul>','</ul>'], ['- ','<br/>','','','',''], $new->text);
        $data = Str::replace(['<h2 style="text-align:center">','</h2>'], ['<p>= = = = = = = =&nbsp;&nbsp;','&nbsp;&nbsp;= = = = = = = =</p><br/>'], $data);
        return $data . '</p></body></html>';
    }
    
    /**
     * GET /api/status
     */
    public function status()
    {
        $servers        = config('aion.servers');
        $serversStatus  = [];
        
        foreach ($servers as $key => $server) {
            if(!$server['enabled']) continue;
            if(cache()->has('status.'.$key)) {
                $serversStatus[] = [
                    'name'   => $key,
                    'status' => cache('status.'.$key)
                ];
            } elseif ($key == 'Discord') {
                $serversStatus[] = [
                    'name'   => $key,
                    'status' => true
                ];
            }
            
        }
        
        return $serversStatus;
    }
    
    /**
     * GET /api/slider
     */
    public function slider()
    {
        $sliders = cache('sliders');
        
        return view('_api.master', [
            'slider' => $sliders
        ]);
    }
    
}
