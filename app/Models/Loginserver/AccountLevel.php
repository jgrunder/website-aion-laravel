<?php

namespace App\Models\Loginserver;

use Illuminate\Database\Eloquent\Model;

class AccountLevel extends Model {

    protected $table        = 'account_level';
    protected $connection   = 'loginserver';
    protected $fillable     = ['id', 'account_id', 'total', 'level'];
    public $timestamps      = false;


}
