<?php

if (!function_exists('createThumbnail')) {
    function createThumbnail($pathName)
    {
        $maxWidth = 320;
        $maxAspectRatio = 2/1;
        $img = Image::make($pathName.'.jpg');
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

        $img->save($pathName.'-tn.jpg');

        return $height / $width;
    }
}

if (!function_exists('createPoster')) {
    function createPoster($pathName)
    {
        $options = [
            'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/bin/ffprobe',
            'timeout'          => 3600, // The timeout for the underlying process
            'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
        ];
        $duration = FFMpeg\FFProbe::create($options)->format($pathName.'.mp4')->get('duration');

        $video = FFMpeg\FFMpeg::create($options)->open($pathName.'.mp4');
        $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(0.5 * $duration))->save($pathName.'.jpg');
    }
}