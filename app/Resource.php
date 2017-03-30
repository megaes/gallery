<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = ['name', 'caption', 'tn_aspect_ratio'];

    public function album()
    {
        return $this->belongsTo('App\Album');
    }
}
