<?php

namespace App\Http\Controllers;

use App\Models\Gameserver\Player;
use App\Models\Webserver\News;
use Carbon\Carbon;

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
        $news = News::orderBy('created_at', 'DESC')->limit(3)->get();
        $data = '';
        foreach ($news as $new) {
            $data .= '&#8224; ' . $new->title . ' (<a href="' . route('news', [$new->slug, $new->id]) . '" target="_blank">' . Carbon::parse($new->created_at)->format('d/m/Y') . '</a>)<br/>';
        }
        return ['html' => $data];
    }
    
}
