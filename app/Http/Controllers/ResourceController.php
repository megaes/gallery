<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Resource;
use App\Album;

class ResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function update(Request $request, Resource $resource)
    {
        if($resource->album->user->id != Auth::id()) {
            return response('Unauthorized operation!', 403);
        }
        if ($request->has('caption')) {
            $resource->update(['caption' => $request->input('caption')]);
        }
        return '';
    }
    public function delete(Request $request)
    {
        if($request->has('ids')) {
            $ids = $request->input('ids');
            $resources = Resource::findMany($ids, ["name", "album_id"]);
            $album = $resources->first()->album;
            $path = $album->path();
            foreach($resources as $resource) {
                if($resource->album_id != $album->id) {
                    return response('Unauthorized operation!', 403);
                }
            }
            if($album->user->id != Auth::id()) {
                return response('Unauthorized operation!', 403);
            }
            foreach($resources as $resource) {
                Storage::delete(["{$path}{$resource->name}-tn.jpg", "{$path}{$resource->name}.jpg"]);
            }
            Resource::destroy($ids);
        }
        return '';
    }
}
