<?php

namespace App\Models\Webserver;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model {

    protected $table        = 'pages';
    protected $connection   = 'webserver';
    protected $fillable     = ['page_name', 'fr', 'en'];
    public $timestamps      = false;

}
