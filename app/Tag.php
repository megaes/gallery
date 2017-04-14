<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function resources()
    {
        return $this->belongsToMany(Resource::class);
    }

    public static function deleteSQL($ids)
    {
        if(empty($ids)) {
            return;
        }
        DB::delete('delete from tags where id in '.queryBindings(count($ids)), $ids);
    }
}
