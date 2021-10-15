<?php

namespace App\Models\Gameserver;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbyssRank extends Model
{
    use HasFactory;
    
    protected $table        = 'abyss_rank';
    protected $connection   = 'gameserver';
    public $timestamps      = false;
    
    /**
     * Reset the abyssal rank of the player
     * @param $query
     * @return
     */
    public function scopeReset($query) {
        return $query->update([
            'daily_ap'      => 0,
            'weekly_ap'     => 0,
            'ap'            => 0,
            'rank'          => 1,
            'daily_kill'    => 0,
            'weekly_kill'   => 0,
            'all_kill'      => 0,
            'last_kill'     => 0,
            'last_ap'       => 0,
        ]);
    }
    
    /**
     * Return player
     */
    public function player()
    {
        return $this->hasOne('App\Models\Gameserver\Player', 'id', 'player_id');
    }
}
