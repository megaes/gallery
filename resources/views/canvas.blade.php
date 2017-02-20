@extends('layouts.app')

@section('gallery navbar')
<li>
    <a href="{{ url('/') }}" onclick="event.preventDefault(); $('#media-form').submit();">
        <span class="glyphicon glyphicon-picture"></span>
        Photo
    </a>
    <form id="media-form" action="{{ url('/') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Albums <span class="caret"></span></a>
    <ul class="dropdown-menu scrollable-menu">
        <li><a href="#">New</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Another action</a></li>
        <li><a href="#">Something else here</a></li>
        <li><a href="#">Action</a></li>
        <li><a href="#">Another action</a></li>
        <li><a href="#">Something else here</a></li>
        <li><a href="#">Action</a></li>
        <li><a href="#">Another action</a></li>
        <li><a href="#">Something else here</a></li>
        <li><a href="#">Action</a></li>
        <li><a href="#">Another action</a></li>
        <li><a href="#">Something else here</a></li>
        <li><a href="#">Action</a></li>
        <li><a href="#">Another action</a></li>
    </ul>
</li>

<li>
    <form class="navbar-form">
        <div class="input-group">
            <input id="search-input" type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
                <button class="btn btn-default">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </span>
        </div>
    </form>
</li>
@endsection


@section('debug style')

    .light-gallery > .grid-item {
        border: 1px solid #FFF;
        position: relative;
        overflow: hidden;
        padding: 0px;
    }

    .light-gallery > .grid-item > img {
        width: 100%;
        -webkit-transition: -webkit-transform 0.15s ease 0s;
        -moz-transition: -moz-transform 0.15s ease 0s;
        -o-transition: -o-transform 0.15s ease 0s;
        transition: transform 0.15s ease 0s;
        -webkit-transform: scale3d(1, 1, 1);
        transform: scale3d(1, 1, 1);
    }
    .light-gallery > a:hover > img {
        -webkit-transform: scale3d(1.1, 1.1, 1.1);
        transform: scale3d(1.1, 1.1, 1.1);
    }


    .light-gallery > .grid-item:hover .demo-gallery-poster > img {
        opacity: 1;
    }

    .light-gallery > .grid-item .demo-gallery-poster {
        background-color: rgba(0, 0, 0, 0);
        bottom: 0;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        -webkit-transition: background-color 0.15s ease 0s;
        -o-transition: background-color 0.15s ease 0s;
        transition: background-color 0.15s ease 0s;
    }

    .light-gallery > .grid-item .demo-gallery-poster > img {
        left: 50%;
        margin-left: -10px;
        margin-top: -10px;
        opacity: 0;
        position: absolute;
        top: 50%;
        -webkit-transition: opacity 0.3s ease 0s;
        -o-transition: opacity 0.3s ease 0s;
        transition: opacity 0.3s ease 0s;
    }

    .light-gallery > .grid-item:hover .demo-gallery-poster {
        background-color: rgba(0, 0, 0, 0.5);
    }

@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <h1> Album 1</h1>
        </div>

        <div class="light-gallery row">
            @for ($i = 1, $n = 1; $i <= 200; $i++, $n = rand(1, 16) )
                <a class="grid-item col-xs-4 col-sm-3 col-md-2 col-lg-1" data-tweet-text="Say something about this..." data-twitter-share-url="https://1drv.ms/i/s!AtbI7T-Zhxq1hEMvNwKaW6zZaLP_" data-facebook-share-url="https://1drv.ms/i/s!AtbI7T-Zhxq1hEMvNwKaW6zZaLP_" href="resources/img/{{ $n }}.jpg" data-sub-html=".caption">
                    <img src="resources/img/{{ $n }}.jpg" />
                    <div class="demo-gallery-poster">
                        <img src="resources/zoom.png">
                    </div>
                    <div class="caption" style="display:none">
                        <h4>Bowness Bay</h4><p>A beautiful Sunrise this morning taken En-route to Keswick not one as planned but I'm extremely happy I was passing the right place at the right time....</p>
                    </div>
                </a>
            @endfor
        </div>

        <div class="row">
            <h1> Album 2</h1>
        </div>

        <div class="light-gallery row">
            @for ($i = 1, $n = 1; $i <= 110; $i++, $n = rand(1, 16))
                <a class="grid-item col-xs-4 col-sm-3 col-md-2 col-lg-1" data-tweet-text="share on twitter {{ $n }}" href=resources/img/{{ $n }}.jpg">
                    <img src="resources/img/{{ $n }}.jpg" alt="caption{{ $n }}"/>
                    <div class="demo-gallery-poster">
                        <img src="resources/zoom.png">
                    </div>
                </a>
            @endfor
        </div>

        <div class="row">
            <h1> Album 3</h1>
        </div>

        @for( $j = 1, $i = 1; $j <= 20; $j++, $i = rand(1, 4))
            <!-- Hidden video div -->
            <div style="display:none;" id="video{{ $i }}">
                <video class="lg-video-object lg-html5" controls preload="none">
                    <source src="resources/videos/video{{ $i }}.mp4" type="video/mp4">
                    Your browser does not support HTML5 video.
                </video>
            </div>
        @endfor

        <!-- data-src should not be provided when you use html5 videos -->
        <div class="light-gallery html5-videos row">
            @for( $j = 1, $i = 1; $j <= 20; $j++, $i = rand(1, 4))
                <a class="grid-item col-xs-4 col-sm-3 col-md-2 col-lg-1" data-tweet-text="share on twitter {{ $i }}" data-poster="resources/videos/video-poster{{ $i }}.jpg" data-sub-html="video caption{{ $i }}" data-html="#video{{ $i }}" >
                    <img src="resources/videos/video-poster{{ $i }}.jpg" />
                    <div class="demo-gallery-poster">
                        <img src="resources/zoom.png">
                    </div>
                </a>
            @endfor
        </div>
    </div>
@endsection

@section('debug script')
    <script>
        $(function() {

            $('div.light-gallery').each( function(index) {

                var msnry = new Masonry( this, {
                    itemSelector: '.grid-item',
                    columnWidth: '.grid-item',
                    percentPosition: true
                });

                imagesLoaded( this, function() {
                    msnry.layout();
                });

                $(this).lightGallery({
                    subHtmlSelectorRelative: true,
                    thumbnail: true,
                    pinterest: false,
                    googlePlus: false,
                    galleryId: index + 1
                });

            });

            $('.light-gallery.html5-videos').each( function(index) {
                var msnry = new Masonry( this, {
                    itemSelector: '.grid-item',
                    columnWidth: '.grid-item',
                    percentPosition: true
                });

                imagesLoaded( this, function() {
                    msnry.layout();
                });

                $(this).lightGallery({
                    pinterest: false,
                    googlePlus: false,
                    zoom: false,
                    autoplayControls: false,
                    galleryId: 3
                });
            });


        });
    </script>
@endsection


