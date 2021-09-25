<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/online', ['uses'   => 'ApiController@online']);
Route::get('/news', ['uses'   => 'ApiController@news']);
Route::get('/status', ['uses'   => 'ApiController@status']);
Route::get('/slider', ['uses'   => 'ApiController@slider']);
