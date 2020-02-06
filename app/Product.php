<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];
    protected $with = ['prices', 'price', 'files:name,uri,ext,file_tag_id'];

    public function prices()
    {
        return $this->hasMany(
            'App\PriceDescription'
        );
    }

    public function price()
    {
        return $this->belongsTo('App\PriceDescription', 'primary_price_id');
    }

    public function image()
    {
        return $this->belongsTo('App\File', 'image_file_id');
    }

    public function files()
    {
        return $this->belongsToMany('App\File', 'file_product')->with('tag:id,name');
    }

    public function mainSupplier()
    {
        return $this->belongsTo('App\Supplier', 'supplier_id');
    }
}
