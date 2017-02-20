<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function index(Request $request) {
        if ($request->has("thumbnails")) {
            $maxSize = 250;
            for($i = 1; $i <= 16; ++$i) {
                $img = Image::make("resources/img/{$i}.jpg");
                $width = $img->getWidth();
                $height = $img->getHeight();
                $k = $maxSize / $width;
                $img->resize($width * $k, $height * $k);
                $img->save("resources/img/tn-{$i}.jpg");
            }
            return "process images";
        }
        return view('canvas');
    }
}
