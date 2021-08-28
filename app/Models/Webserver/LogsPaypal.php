<?php

namespace App\Models\Webserver;

use Illuminate\Database\Eloquent\Model;

class LogsPaypal extends Model {

    protected $table        = 'logs_paypal';
    protected $connection   = 'webserver';
    protected $fillable     = ['id', 'id_account', 'price', 'txnid', 'amount', 'name', 'country', 'city', 'address', 'email', 'status', 'created_at', 'updated_at'];

}
