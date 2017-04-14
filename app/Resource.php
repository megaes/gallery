<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Resource extends Model
{
    protected $fillable = ['name', 'caption', 'tn_aspect_ratio'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public static function deleteSQL($ids)
    {
        if(empty($ids)) {
            return;
        }
        DB::delete('delete from resources where id in '.queryBindings(count($ids)), $ids);
    }
}
