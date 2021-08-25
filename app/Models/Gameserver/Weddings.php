<?php

namespace App\Models\Gameserver;

use Illuminate\Database\Eloquent\Model;

class Weddings extends Model {

    protected $table        = 'weddings';
    protected $connection   = 'gameserver';
    protected $fillable     = ['id'];
    public $timestamps      = false;

    /**
     * Return first player
     */
    public function firstPlayer()
    {
        return $this->belongsTo('App\Models\Gameserver\Player', 'player1', 'id');
    }

    /**
     * Return second player
     */
    public function secondPlayer()
    {
        return $this->belongsTo('App\Models\Gameserver\Player', 'player2', 'id');
    }

}
