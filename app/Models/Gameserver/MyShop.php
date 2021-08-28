<?php

namespace App\Models\Gameserver;

use Illuminate\Database\Eloquent\Model;

class MyShop extends Model {

    protected $table        = 'myshop';
    protected $connection   = 'gameserver';
    protected $fillable     = ['item', 'nb', 'player_id'];
    public $timestamps      = false;

}
