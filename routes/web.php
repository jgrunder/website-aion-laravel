<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * PATTERNS
 *
 */
Route::pattern('id', '[0-9]+');
Route::pattern('playerId', '[0-9]+');
Route::pattern('accountId', '[0-9]+');

/**
 * ROUTES
 */
Route::get('/', ['as' => 'home', 'uses'   => 'HomeController@index']);
Route::get('/reset-password/{token}/{name}', ['as' => 'resetpassword', 'uses' => 'LostPasswordController@reset']);
Route::get('/news/{slug}/{id}', ['as' => 'news', 'uses' => 'HomeController@news']);
Route::get('/vote/{id}', ['as' => 'vote', 'uses' => 'VoteController@index', 'middleware' => 'connected']);
Route::get('/language/{language}', ['as' => 'language', 'uses' => 'LanguageController@change']);
Route::get('donation', ['as' => 'donation', 'uses' => 'PageController@donation', 'middleware' => 'connected']);

/** Shop */
Route::group(['prefix' => 'shop', 'middleware' => ['connected']], function() {
    Route::get('', ['as' => 'shop', 'uses' => 'ShopController@index']);
    Route::get('search', ['as' => 'shop.search', 'uses' => 'ShopController@search']);
    Route::get('category/{id}', ['as' => 'shop.category', 'uses' => 'ShopController@category']);
    Route::get('add/{id}', ['as' => 'shop.add', 'uses' => 'ShopController@addToCart']);
    Route::get('remove/{id}', ['as' => 'shop.remove', 'uses' => 'ShopController@removeToCart']);
    Route::get('summary', ['as' => 'shop.summary', 'uses' => 'ShopController@summary']);
    Route::post('summary', ['as' => 'shop.summary', 'uses' => 'ShopController@buy']);
});
    
/** Paiement */
Route::get('allopass', ['as' => 'allopass', 'uses' => 'PaiementController@allopass', 'middleware' => 'connected']);
Route::get('allopass/success', ['as' => 'allopass.success', 'uses' => 'PaiementController@allopassSuccess', 'middleware' => 'connected']);
Route::get('paypal', ['as' => 'paypal', 'uses' => 'PaiementController@paypal', 'middleware' => 'connected']);
Route::post('paypal-ipn', ['as' => 'paypal.ipn', 'uses' => 'PaiementController@paypalIpn']);
Route::get('paypal-valid', ['as' => 'paypal.valid', 'uses' => 'PaiementController@paypalValid']);
    
/** User */
Route::group(['prefix' => 'user'], function() {
    Route::get('subscribe', ['as' => 'user.subscribe', 'uses' => 'UserController@subscribe', 'middleware' => 'guest']);
    Route::post('subscribe', 'UserController@createAccount')->middleware('guest');
    Route::post('login', 'UserController@connect')->middleware('guest');
    Route::get('logout', ['as' => 'user.logout', 'uses' => 'UserController@logout'])->middleware('connected');
    Route::get('unlock/{playerId}/{accountId}', ['as' => 'user.unlock.player', 'uses'=> 'UserController@unlockPlayer']);
    Route::get('account', ['as' => 'user.account', 'uses' => 'UserController@account', 'middleware' => 'connected']);
    Route::match(['GET', 'POST'], 'edit', ['as' => 'user.account.edit', 'uses' => 'UserController@edit', 'middleware' => 'connected']);
    Route::match(['GET', 'POST'], 'lost-password', ['as' => 'user.lost_password', 'uses' => 'LostPasswordController@index']);
});
        
/** Stats */
Route::group(['prefix' => 'stats'], function() {
    Route::get('players-online', ['as' => 'stats.online', 'uses' => 'StatsController@online']);
    Route::get('legions', ['as' => 'stats.legions', 'uses' => 'StatsController@legions']);
});
    
/** Database */
Route::group(['prefix' => 'database'], function() {
    Route::get('item/{id}', ['as' => 'database.item', 'uses' => 'DatabaseController@item']);
});
                
/** Page */
Route::group(['prefix' => 'page'], function() {
    Route::get('joins-us', ['as' => 'page.joins-us', 'uses' => 'PageController@joinUs']);
    Route::get('teamspeak', ['as' => 'page.teamspeak', 'uses' => 'PageController@teamspeak']);
    Route::get('discord', ['as' => 'page.discord', 'uses' => 'PageController@discord']);
    Route::get('rules', ['as' => 'page.rules', 'uses' => 'PageController@rules']);
    Route::get('team', ['as' => 'page.team', 'uses' => 'PageController@team']);
    Route::get('rates-of-server', ['as' => 'page.rates', 'uses' => 'PageController@rates']);
    Route::get('error', ['as' => 'page.error', 'uses' => 'PageController@error']);
});
                    
/** Admin */
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['connected', 'admin']], function() {
    
    Route::get('home', ['as' => 'admin', 'uses' => 'NewsController@index']);
    Route::get('search', ['as' => 'admin.search', 'uses' => 'AdminController@search']);
    Route::get('logs/{name}', ['as' => 'admin.logs', 'uses' => 'AdminController@logs']);
    route::match(['GET', 'POST'], 'page/{name}', ['as' => 'admin.page', 'uses' => 'AdminController@pageEdit']);
    route::match(['GET', 'POST'], 'add-points', ['as' => 'admin.add.points', 'uses' => 'AdminController@addPoints']);
    route::match(['GET', 'POST'], 'slider', ['as' => 'admin.slider', 'uses' => 'AdminController@slider']);
    route::match(['GET', 'POST'], 'pushbullet', ['as' => 'admin.pushbullet', 'uses' => 'AdminController@pushbullet']);
    
    /** Shop */
    Route::group(['prefix' => 'shop'], function() {
        Route::get('/all', ['as' => 'admin.shop.all', 'uses' => 'ShopController@allItems']);
        Route::match(['GET', 'POST'], 'category', ['as' => 'admin.shop.category', 'uses' => 'ShopController@shopCategory']);
        Route::get('category/{id}', ['as' => 'admin.shop.category.items', 'uses' => 'ShopController@ItemsInCategory']);
        Route::match(['GET', 'POST'], 'subcategory', ['as' => 'admin.shop.subcategory', 'uses' => 'ShopController@shopSubCategory']);
        Route::get('subcategory/{id}', ['as' => 'admin.shop.subcategory.items', 'uses' => 'ShopController@ItemsInSubCategory']);
        Route::match(['GET', 'POST'], 'add', ['as' => 'admin.shop.add', 'uses' => 'ShopController@shopAdd']);
        Route::match(['GET', 'POST'], 'edit/{id}', ['as' => 'admin.shop.edit', 'uses' => 'ShopController@shopEdit']);
        Route::get('delete/{id}', ['as' => 'admin.shop.delete', 'uses' => 'ShopController@shopDelete']);
    });
        
    /** Paiement */
    Route::group(['prefix' => 'paiement'], function() {
        Route::get('allopass', ['as' => 'admin.allopass', 'uses' => 'AdminController@allopass']);
        Route::get('paypal', ['as' => 'admin.paypal', 'uses' => 'AdminController@paypal']);
        Route::get('points', ['as' => 'admin.points', 'uses' => 'AdminController@points']);
    });
        
    /** News */
    Route::group(['prefix' => 'news'], function() {
        Route::get('', ['as' => 'admin.news', 'uses' => 'NewsController@news']);
        Route::match(['GET', 'POST'], 'add', ['as' => 'admin.news.add', 'uses' => 'NewsController@newsAdd']);
        Route::match(['GET', 'POST'], 'edit/{id}', ['as' => 'admin.news.edit', 'uses' => 'NewsController@newEdit']);
        Route::get('delete/{id}', ['as' => 'admin.news.delete', 'uses' => 'NewsController@newsDelete']);
    });
                
});
                        