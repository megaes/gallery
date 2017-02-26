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
            for($i = 1; $i <= 500; ++$i) {
                $n = max(1, $i % 16 );
                $img = Image::make("resources/src/{$n}.jpg");
                $width = $img->getWidth();
                $height = $img->getHeight();
/*
                $k = 3/2;
                if($width > $height) {

                    if($width > $height * $k) {
                        $img->resizeCanvas(round($height * $k), $height, 'center');
                    } else {
                        $img->resizeCanvas($width, round($width / $k), 'center');
                    }
                } else {
                    if($width * $k < $height) {
                        $img->resizeCanvas($width, round($width * $k), 'top');
                    } else {
                        $img->resizeCanvas(round($height / $k), $height,'top');
                    }
                }
    */
                $img->fit(300);
                $img->save("resources/img/tn-{$i}.jpg");
            }
            return "thumbnails updated!";
        }
        return view('canvas');
    }
}
