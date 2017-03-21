<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = ['caption'];

    public function album()
    {
        return $this->belongsTo('App\Album');
    }
}
