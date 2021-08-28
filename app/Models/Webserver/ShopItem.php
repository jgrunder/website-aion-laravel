<?php

namespace App\Models\Webserver;

use Illuminate\Database\Eloquent\Model;

class ShopItem extends Model {

    protected $table        = 'shop_items';
    protected $connection   = 'webserver';
    protected $fillable     = ['id_item', 'quality_item', 'id_sub_category', 'name', 'price', 'quantity', 'level', 'preview'];
    public $timestamps      = false;

    public function sub()
    {
      return $this->belongsTo('App\Models\Webserver\ShopSubCategory', 'id_sub_category', 'id');
    }

    public function scopeWithCategory($query)
    {
      return $query->with(['sub' => function($query) {
        return $query->with('category');
      }]);
    }

}
