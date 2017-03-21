<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Resource;
use App\Album;
use Image;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    protected function createThumbnail($filename)
    {
        $maxWidth = 320;
        $maxAspectRatio = 2/1;
        $img = Image::make('resources/src/'.$filename.'.jpg');
        $width = $img->getWidth();
        $height = $img->getHeight();

        if($width > $height * $maxAspectRatio) {
            $width = round($height * $maxAspectRatio);
            $img->resizeCanvas($width, $height, 'center');
        } else if($width * $maxAspectRatio < $height) {
            $height = round($width * $maxAspectRatio);
            $img->resizeCanvas($width, $height, 'top');
        }

        $height = round($maxWidth * ($height / $width));
        $width = $maxWidth;
        $img->resize($width, $height);

        $img->save('resources/0/'.$filename.'-tn.jpg');

        return $height / $width;
    }


    public function thumbnails()
    {
        return "unexpected call";

        $aspects = ['66.88',
                    '150.00',
                    '66.88',
                    '66.88',
                    '56.25',
                    '60.00',
                    '50.00',
                    '63.75',
                    '56.25',
                    '75.00',
                    '69.69',
                    '62.19',
                    '65.31',
                    '66.88',
                    '66.88',
                    '66.88'];

        for($i = 901; $i <= 1000; ++$i) {
            //$n = $i;
            $n = rand(1, 16);

            $img = Image::make("resources/0/{$n}-tn.jpg");
            $img->save("resources/0/{$i}-tn.jpg");
            $img = Image::make("resources/0/{$n}.jpg");
            $img->save("resources/0/{$i}.jpg");

            $resource = new Resource;
          //  $resource->tn_aspect_ratio = 100.0 * $this->createThumbnail("{$n}");
            $resource->tn_aspect_ratio = $aspects[$n-1];
            $resource->album_id = 1;
            $resource->name = "{$i}";
            $resource->caption = "Caption {$i}";
            $resource->save();

        }
        return "thumbnails updated!!!!";
    }

    public function index()
    {
        return view('canvas');
    }
}

