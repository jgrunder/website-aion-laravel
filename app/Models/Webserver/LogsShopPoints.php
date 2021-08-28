<?php

namespace App\Models\Webserver;

use Illuminate\Database\Eloquent\Model;

class LogsShopPoints extends Model {

    protected $table        = 'logs_shop_points';
    protected $connection   = 'webserver';
    protected $fillable     = ['id', 'sender_name', 'receiver_name', 'points', 'reason', 'created_at', 'updated_at'];

}
