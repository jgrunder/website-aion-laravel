<?php

namespace App\Models\Webserver;

use Illuminate\Database\Eloquent\Model;

class News extends Model {

    protected $table        = 'news';
    protected $connection   = 'webserver';
    protected $fillable     = ['title', 'slug', 'text', 'account_id'];

    public function creator(){
        return $this->belongsTo('App\Models\Loginserver\AccountData', 'account_id', 'id');
    }

}
