<?php

namespace App\Models\Webserver;

use Illuminate\Database\Eloquent\Model;

class LogsAllopass extends Model {

    protected $table        = 'logs_allopass';
    protected $connection   = 'webserver';
    protected $fillable     = ['id_allopass', 'id_account', 'created_at', 'updated_at'];

    public static function check($id_allopass)
    {
        return LogsAllopass::where('id_allopass', '=', $id_allopass)->first();
    }

    public static function insert($id_allopass, $id_account)
    {
        return LogsAllopass::create([
            'id_allopass' => $id_allopass,
            'id_account'  => $id_account
        ]);
    }

}
