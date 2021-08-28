<?php

namespace App\Models\Webserver;

use Illuminate\Database\Eloquent\Model;

class ShopHistory extends Model {

    protected $table        = 'shop_history';
    protected $connection   = 'webserver';
    protected $fillable     = ['account_id', 'item_id', 'quantity', 'price', 'name', 'player_id', 'player_name'];

}