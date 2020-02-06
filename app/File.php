<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = ['id'];

    

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function tag()
    {
        return $this->belongsTo('App\FileTag', 'file_tag_id');
    }
}
