<?php

namespace App\Models\Gameserver;

use Illuminate\Database\Eloquent\Model;

class Legion extends Model {

    protected $table        = 'legions';
    protected $connection   = 'gameserver';
    protected $fillable     = ['contribution_points'];
    public $timestamps      = false;

}
