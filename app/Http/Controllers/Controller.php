<?php

namespace App\Http\Controllers;

use App\Models\Gameserver\Player;
use App\Models\Gameserver\Weddings;
use App\Models\Loginserver\AccountData;
use App\Models\Loginserver\AccountVote;
use App\Models\Webserver\ConfigSlider;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * @var $language
     */
    protected $language;
    
    /**
     * Set global Variables for ALL view
     */
    public function __construct()
    {
        $this->serversTest();
        $this->accountVotes();
        $this->countPlayersOnline();
        $this->accountShopPoints();
        $this->topVotes();
        $this->getLanguageFromCookie();
        $this->getSlider();
        $this->weddings();
    }
    
    /**
     * Set Variables $countPlayersOnline
     */
    private function countPlayersOnline()
    {
        $count_asmodians = Cache::remember('online_number_asmodians', Config::get('aion.cache.online_number'), function() {
            return Player::online()->where('race', '=', 'ASMODIANS')->count();
        });
            
        $count_elyos = Cache::remember('online_number_elyos', Config::get('aion.cache.online_number'), function() {
            return Player::online()->where('race', '=', 'ELYOS')->count();
        });
            
        View::share('countPlayersOnlineAsmodians', $count_asmodians);
        View::share('countPlayersOnlineElyos', $count_elyos);
    }
    
    /**
     * Set Variable $weddings
     */
    private function weddings()
    {
        if(Config::get('aion.enable_weddings')){
            View::share('weddings', Weddings::orderBy('id', 'DESC')->take(5)->get());
        }
    }
    
    /**
     * Set Variable $slider
     */
    private function getSlider()
    {
        $sliders = Cache::rememberForever('sliders', function() {
            return ConfigSlider::all();
        });
            
        View::share('slider', $sliders);
    }
    
    /**
     * Update Variable in the session
     */
    private function accountShopPoints()
    {
        if(Session::has('connected')) {
            $user = AccountData::me(Session::get('user.id'))->first(['shop_points']);
            Session::put('user.shop_points', $user['shop_points']);
        }
        else {
            Session::put('user.shop_points', 0);
        }
    }
    
    /**
     * Set Variable $accountVotes
     */
    private function accountVotes()
    {
        if(Session::has('connected')) {
            $accountId      = Session::get('user.id');
            $votesInConfig  = Config ::get('aion.vote.links');
            $votesAvailable = [];
            
            foreach ($votesInConfig as $key => $value) {
                $vote = AccountVote::where('account_id', $accountId)->where('site', $key)->first();
                
                if ($vote === null) {
                    $votesAvailable[] = [
                        'id'     => $key,
                        'status' => true
                    ];
                } else {
                    $date = Carbon::parse($vote->date);
                    if ($date->diffInHours(Carbon::now()) >= 2) {
                        $votesAvailable[] = [
                            'id'     => $key,
                            'status' => true
                        ];
                    } else {
                        $diff = $date->addHours(2)->subHours(Carbon::now()->hour)->subMinutes(Carbon::now()->minute);
                        $votesAvailable[] = [
                            'id'            => $key,
                            'status'        => false,
                            'diff_hours'    => ($diff->format('g') == 12) ? null : $diff->format('g'),
                            'diff_minutes'  => $diff->format('i')
                        ];
                    }
                }
            }
            
            View::share('accountVotes', $votesAvailable);
        }
    }
    
    /**
     * Set Variable $topVotes
     */
    private function topVotes()
    {
        $voters = Cache::remember('top_votes', Config::get('aion.cache.top_vote'), function() {
            return AccountData::where('vote', '>', 0)->orderBy('vote', 'DESC')->take(5)->get();
        });
            
        View::Share('topVotes', $voters);
    }
    
    /**
     * Set Variable $serversStatus
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
                $expiresAt  = Carbon::now()->addMinutes(5);
                
                try {
                    $check = fsockopen($server['ip'], $server['port'], $errno, $errstr, 1.0);
                    
                    Cache::put('status.'.$key, ($check) ? true : false, $expiresAt);
                    
                    $serversStatus[] = [
                        'name'   => $key,
                        'status' => ($check) ? true : false
                    ];
                    
                    fclose($check);
                    
                } catch (\Throwable $e) {
                    Cache::put('status.'.$key, false, $expiresAt);
                }
                
            }
            
        }
        
        View::share('serversStatus', $serversStatus);
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
