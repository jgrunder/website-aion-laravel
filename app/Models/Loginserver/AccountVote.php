<?php

namespace App\Models\Loginserver;

use Illuminate\Database\Eloquent\Model;

class AccountVote extends Model {

    protected $table        = 'account_votes';
    protected $connection   = 'loginserver';
    protected $fillable     = ['account_id', 'site', 'date'];
    public $timestamps      = false;

}