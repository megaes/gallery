<?php

namespace App\Http\Controllers;

use Image;
use App\Album;
use App\Resource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return DB::select('select id, name, type from albums where albums.user_id = ?', [Auth::id()]);
    }
    public function create(Request $request)
    {
        if(!$request->has('type')) {
            return response('Bad request!', 400);
        }
        $frames = $request->input('frames', []);
        $newAlbum = Auth::user()->albums()->create(['type' => $request->input('type'), 'name' => 'New Album']);
        $newPath = $newAlbum->path();
        Storage::makeDirectory($newPath);

        if(!empty($frames)) {
            $resources = Resource::findMany($frames);
            $oldAlbum = $resources->first()->album;
            $oldPath = $oldAlbum->path();
            if($resources->where('album_id', '!=', $oldAlbum->id)->isNotEmpty() || ($oldAlbum->user->id != Auth::id())) {
                Storage::deleteDirectory($newPath);
                $newAlbum->delete();
                return response('Unauthorized operation!', 403);
            }
            if($oldAlbum->type != $newAlbum->type) {
                Storage::deleteDirectory($newPath);
                $newAlbum->delete();
                return response('Bad request!', 400);
            }
            foreach($resources as $resource) {
                Storage::move("{$oldPath}{$resource->name}-tn.jpg", "{$newPath}{$resource->name}-tn.jpg");
                Storage::move("{$oldPath}{$resource->name}.jpg", "{$newPath}{$resource->name}.jpg");
                $resource->album_id = $newAlbum->id;
                $resource->save();
            }
            if($newAlbum->type == 'video') {
                foreach($resources as $resource) {
                    Storage::move("{$oldPath}{$resource->name}.mp4", "{$newPath}{$resource->name}.mp4");
                }
            }
        }
        return response()->json([ 'id' => $newAlbum->id, 'name' => $newAlbum->name, 'type' => $newAlbum->type]);
    }
    public function getResources(Album $album)
    {
        if($album->user->id != Auth::id()) {
            return response('Unauthorized operation!', 403);
        }
        $resources = [];
        foreach(DB::select('select id, name, caption, tn_aspect_ratio from resources where resources.album_id = ?', [$album->id]) as $resource) {
            $resource->tags = [];
            $resources[$resource->id] = $resource;
        }
        if(!empty($resources)) {
            $query = 'select tags.name, resource_tag.resource_id as pivot_resource_id from tags inner join resource_tag on tags.id = resource_tag.tag_id where resource_tag.resource_id in ';
            foreach(DB::select($query.queryBindings(count($resources)), array_keys($resources)) as $tag) {
                $resources[$tag->pivot_resource_id]->tags[] = $tag->name;
            }
        }
        return response()->json(['frames' => array_values($resources), 'path' => 'storage/'.$album->path()]);
    }
    public function getTags(Album $album)
    {
        if($album->user->id != Auth::id()) {
            return response('Unauthorized operation!', 403);
        }
        $tags = [];
        $resources = [];
        foreach(DB::select('select id from resources where resources.album_id = ?', [$album->id]) as $resource) {
            $resources[] = $resource->id;
        }
        if(!empty($resources)) {
            $query = 'select tags.name from tags inner join resource_tag on tags.id = resource_tag.tag_id where resource_tag.resource_id in ';
            foreach(DB::select($query.queryBindings(count($resources)), $resources) as $tag) {
                $tags[$tag->name] = 1;
            }
        }
        return array_keys($tags);
    }
    public function update(Request $request, $id)
    {
        if($request->has('frames')) {
            $resources = Resource::findMany($request->input('frames'));
            if($resources->isNotEmpty()) {
                $oldAlbum = $resources->first()->album;
                $newAlbum = Album::withCount('resources')->find($id);
                if(
                    $resources->where('album_id', '!=', $oldAlbum->id)->isNotEmpty() ||
                    ($oldAlbum->user->id != Auth::id()) ||
                    ($newAlbum->user->id != Auth::id())
                ) {
                    return response('Unauthorized operation!', 403);
                }
                if($newAlbum->resources_count + $resources->count() > Album::MAX_RESOURCE_COUNT) {
                    return response('Album size limit (' . Album::MAX_RESOURCE_COUNT . ' elements) is exceeded!', 403);
                }
                $newPath = $newAlbum->path();
                $oldPath = $oldAlbum->path();
                foreach($resources as $resource) {
                    Storage::move("{$oldPath}{$resource->name}-tn.jpg", "{$newPath}{$resource->name}-tn.jpg");
                    Storage::move("{$oldPath}{$resource->name}.jpg", "{$newPath}{$resource->name}.jpg");
                    $resource->album_id = $newAlbum->id;
                    $resource->save();
                }
                if($newAlbum->type == 'video') {
                    foreach($resources as $resource) {
                        Storage::move("{$oldPath}{$resource->name}.mp4", "{$newPath}{$resource->name}.mp4");
                    }
                }
            }
        } else if($request->has('name')) {
            $album = Album::find($id);
            if($album->user->id != Auth::id()) {
                return response('Unauthorized operation!', 403);
            }
            $album->update(['name' => $request->input('name')]);
        }
        return '';
    }
    public function delete(Album $album)
    {
        if($album->user->id != Auth::id()) {
            return response('Unauthorized operation!', 403);
        }
        Storage::deleteDirectory($album->path());
        $album->delete();
        return '';
    }
    public function uploadPhoto(Request $request, $id)
    {
        $album = Album::withCount('resources')->findOrFail($id);

        if($album->user->id != Auth::id()) {
            return response('Unauthorized operation!', 403);
        }
        if($album->resources_count >= Album::MAX_RESOURCE_COUNT) {
            return response('Album size limit (' . Album::MAX_RESOURCE_COUNT . ' elements) is exceeded!', 403);
        }
        $file = $request->file('file');

        $name = time().$file->getBasename();
        $pathName = 'storage/'.$album->path().$name;

        $img = Image::make($file->getPathname());
        $img->save($pathName.'.jpg');

        $aspectRatio = 100.0 * createThumbnail($pathName);

        $frame = $album->resources()->create(['name' => $name, 'tn_aspect_ratio' => $aspectRatio, 'caption' => '']);

        return response()->json(['id' => $frame->id, 'name' => $name, 'tn_aspect_ratio' => $aspectRatio, 'caption' => '', 'tags' => []]);
    }
    public function uploadVideo(Request $request, $id)
    {
        $album = Album::withCount('resources')->findOrFail($id);

        if($album->user->id != Auth::id()) {
            return response('Unauthorized operation!', 403);
        }
        if($album->resources_count >= Album::MAX_RESOURCE_COUNT) {
            return response('Album size limit (' . Album::MAX_RESOURCE_COUNT . ' elements) is exceeded!', 403);
        }
        $file = $request->file('file');

        $name = time().$file->getBasename();
        $path = 'storage/'.$album->path();

        $file->move($path, $name.'.mp4');

        createPoster($path.$name);

        $aspectRatio = 100.0 * createThumbnail($path.$name);

        $frame = $album->resources()->create(['name' => $name, 'tn_aspect_ratio' => $aspectRatio, 'caption' => '']);

        return response()->json(['id' => $frame->id, 'name' => $name, 'tn_aspect_ratio' => $aspectRatio, 'caption' => '', 'tags' => []]);
    }

}
