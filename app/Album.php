<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = ['type', 'name', 'album_id'];

    const MAX_RESOURCE_COUNT = 1000;

    public function resources()
    {
        return $this->hasMany('App\Resource');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function path()
    {
        return hash("sha1", $this->user->email).'/'.$this->id.'/';
    }

}
