<?php

namespace App\Models\Webserver;

use Illuminate\Database\Eloquent\Model;

class ConfigSlider extends Model {

    protected $table        = 'config_slider';
    protected $connection   = 'webserver';
    protected $fillable     = ['title', 'path'];
    public $timestamps      = false;

    /**
     * Upload a file
     *
     * @param $file
     * @return mixed
     */
    public static function upload($file)
    {
        $destinationPath    = 'uploads/slider'; // upload path
        $extension          = $file->getClientOriginalExtension(); // getting image extension
        $fileName           = rand(11111,99999).'.'.$extension; // renaming image
        $upload_success     = $file->move($destinationPath, $fileName);

        return $upload_success->getPathname();
    }

}
