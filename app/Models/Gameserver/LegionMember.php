<?php

namespace App\Models\Gameserver;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class LegionMember extends Model {

    protected $table        = 'legion_members';
    protected $connection   = 'gameserver';

    /**
     * Return the Legion
     */
    public function legion()
    {
        return $this->belongsTo('App\Models\Gameserver\Legion', 'legion_id', 'id');
    }

    /**
     * Return Ranking name
     *
     * @param string $value DEPUTY
     *
     * @return string Deputy
     */
    public function getRankAttribute($value)
    {
        $rankingMapper = Lang::get('aion.legion_rank');

        foreach ($rankingMapper as $key => $name) {
            if($value == $key){
                return $name;
                break;
            }
        }
    }

}
