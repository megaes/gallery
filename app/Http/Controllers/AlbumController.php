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
        $frames = $request->input('frames');
        $newAlbum = Auth::user()->albums()->create(['type' => $request->input('type'),'name' => 'New Album']);
        $newPath = $newAlbum->path();
        Storage::makeDirectory($newPath);

        if(!empty($frames)) {
            $resources = Resource::findMany($frames);
            $oldAlbum = $resources->first()->album;
            $oldPath = $oldAlbum->path();
            foreach($resources as $resource) {
                if($resource->album_id != $oldAlbum->id) {
                    Storage::deleteDirectory($newPath);
                    Album::destroy($newAlbum->id);
                    return response('Unauthorized operation!', 403);
                }
            }
            if($oldAlbum->user->id != Auth::id()) {
                Storage::deleteDirectory($newPath);
                Album::destroy($newAlbum->id);
                return response('Unauthorized operation!', 403);
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
    public function get(Album $album)
    {
        if($album->user->id != Auth::id()) {
            return response('Unauthorized operation!', 403);
        }
        $resources = DB::select('select id, name, caption, tn_aspect_ratio from resources where resources.album_id = ?', [$album->id]);
        return response()->json(['frames' => $resources, 'path' => 'storage/'.$album->path()]);
    }
    public function update(Request $request, $id)
    {
        if($request->has('frames')) {
            $frames = $request->input('frames');
            if(!empty($frames)) {
                $resources = Resource::findMany($frames);
                $oldAlbum = $resources->first()->album;
                $newAlbum = Album::withCount('resources')->find($id);
                foreach($resources as $resource) {
                    if($resource->album_id != $oldAlbum->id) {
                        return response('Unauthorized operation!', 403);
                    }
                }
                if(($oldAlbum->user->id != Auth::id()) || ($newAlbum->user->id != Auth::id())) {
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
        Album::destroy($album->id);
        return '';
    }
    public function uploadPhoto(Request $request, $id)
    {
        $album = Album::withCount('resources')->find($id);

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

        return response()->json(['id' => $frame->id, 'name' => $name, 'tn_aspect_ratio' => $aspectRatio, 'caption' => '']);
    }
    public function uploadVideo(Request $request, $id)
    {
        $album = Album::withCount('resources')->find($id);

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

        return response()->json(['id' => $frame->id, 'name' => $name, 'tn_aspect_ratio' => $aspectRatio, 'caption' => '']);
    }

}
