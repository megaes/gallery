<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public function resources()
    {
        return $this->hasMany('App\Resource');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
