<?php

namespace App\Providers;

use App\Models\Loginserver\AccountVote;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use App\Models\Gameserver\Player;
use App\Models\Gameserver\Weddings;
use App\Models\Loginserver\AccountData;
use App\Models\Webserver\ConfigSlider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('_layouts.master', function ($view)
        {
            $this->serversTest();
            $this->accountShopPoints();
        });
        view()->composer('_modules.call_to_action', function ($view)
        {
            $this->countPlayersOnline();
        });
        view()->composer('_modules.right_sidebar', function ($view)
        {
            $this->accountVotes();
            $this->topVotes();
            $this->weddings();
        });
        view()->composer(['_modules.slider', 'admin.slider'], function ($view)
        {
            $this->getSlider();
        });
        view()->composer('admin.*', function ($view)
        {
            $this->serversTest();
            $this->adminLogsMenu();
        });
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
        if(session()->has('connected')) {
            $user = AccountData::me(session()->get('user.id'))->first(['shop_points']);
            session()->put('user.shop_points', $user['shop_points']);
        }
        else {
            session()->put('user.shop_points', 0);
        }
    }
    
    /**
     * Set Variable $accountVotes
     */
    private function accountVotes()
    {
        if(session()->has('connected')) {
            $accountId      = session()->get('user.id');
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
            if(!$server['enabled']) continue;
            if(Cache::has('status.'.$key)){
                $serversStatus[] = [
                    'name'   => $key,
                    'status' => Cache::get('status.'.$key)
                ];
            } elseif ($key == 'Discord') {
                $serversStatus[] = [
                    'name'   => $key,
                    'status' => true
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
                    Log::info('Server ' . $key . ' is not available');
                    $serversStatus[] = [
                        'name'   => $key,
                        'status' => false
                    ];
                    Cache::put('status.'.$key, false, $expiresAt);
                }
                
            }
            
        }
        
        View::share('serversStatus', $serversStatus);
    }
    
    /**
     * Set variables $adminLogsMenu
     */
    private function adminLogsMenu()
    {
        if (session()->has('connected') && session()->get('user.access_level') > 0) {
            
            $logFiles  = Config::get('aion.logs.files');
            $logsMenu  = [];
            
            foreach ($logFiles as $key => $value){
                
                if(session()->get('user.access_level') >= $value['access_level']) {
                    $logsMenu[] = $value['file'];
                }
                
            }
            
            View::share('adminLogsMenu', $logsMenu);
            
        }
    }
}
