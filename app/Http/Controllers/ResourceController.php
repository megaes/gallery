<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Resource;
use App\Tag;
use App\Album;

class ResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function updateCaption(Request $request, Resource $resource)
    {
        if($resource->album->user->id != Auth::id()) {
            return response('Unauthorized operation!', 403);
        }
        $resource->update(['caption' => $request->input('caption','')]);
        return '';
    }
    public function updateTags(Request $request)
    {
        $resources = Resource::with('tags')->findMany($request->input('frames', []));

        if($resources->isEmpty()) {
            return '';
        }
        $album = $resources->first()->album;
        if($resources->where('album_id', '!=', $album->id)->isNotEmpty() || ($album->user->id != Auth::id())) {
            return response('Unauthorized operation!', 403);
        }
        $newTags = [];
        $tags = $request->input('tags', []);
        if(!empty($tags)) {
            foreach(collect(array_fill_keys($tags, 0))->merge(Tag::whereIn('name', $tags)->get()->pluck('id', 'name')) as $key => $value) {
                $newTags[] = $value ? $value : Tag::create(['name' => $key])->id;
            }
        }
        foreach($resources as $resource) {
            $resource->tags()->sync($newTags);
        }
        Tag::deleteSQL(
            Tag::withCount('resources')->findMany(
                $resources->pluck('tags')->flatten()->pluck('id')->unique()->all()
            )->where('resources_count', 0)->pluck('id')->all()
        );
        return '';
    }
    public function delete(Request $request)
    {
        $resources = Resource::findMany($request->input('ids', []));
        if($resources->isEmpty()) {
            return '';
        }
        $album = $resources->first()->album;
        $path = $album->path();
        if($resources->where('album_id', '!=', $album->id)->isNotEmpty() || ($album->user->id != Auth::id())) {
            return response('Unauthorized operation!', 403);
        }
        if($album->type == 'video') {
            foreach($resources as $resource) {
                Storage::delete("{$path}{$resource->name}.mp4");
            }
        }
        foreach($resources as $resource) {
            Storage::delete(["{$path}{$resource->name}-tn.jpg", "{$path}{$resource->name}.jpg"]);
        }
        Resource::deleteSQL($resources->pluck('id')->all());
        return '';
    }
}
