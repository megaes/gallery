@extends('layouts.app')

@section('gallery navbar')
<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
<li><a href="#">Link</a></li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li><a href="#">Action</a></li>
        <li><a href="#">Another action</a></li>
        <li><a href="#">Something else here</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">Separated link</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="#">One more separated link</a></li>
    </ul>
</li>
<li>
    <form class="navbar-form">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
                <button class="btn btn-default">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </span>
        </div>
    </form>
</li>
@endsection

@section('content')
    <h1> Album 1</h1>

    <div id="lightgallery">
        @for ($i = 1; $i <= 16; $i++)
            <a data-tweet-text="Say something about this..." data-twitter-share-url="https://1drv.ms/i/s!AtbI7T-Zhxq1hEMvNwKaW6zZaLP_" data-facebook-share-url="https://1drv.ms/i/s!AtbI7T-Zhxq1hEMvNwKaW6zZaLP_" href="resources/img/{{ $i }}.jpg" data-sub-html=".caption">
                <img src="resources/img/thumb-{{ $i }}.jpg" />
                <div class="caption" style="display:none">
                    <h4>Bowness Bay</h4><p>A beautiful Sunrise this morning taken En-route to Keswick not one as planned but I'm extremely happy I was passing the right place at the right time....</p>
                </div>
            </a>
        @endfor
    </div>

    <h1> Album 2</h1>

    <div id="lightgallery2">
        @for ($i = 1; $i <= 11; $i++)
            <a data-tweet-text="share on twitter {{ $i }}" href=resources/img/{{ $i }}.jpg">
                <img src="resources/img/thumb-{{ $i }}.jpg" alt="caption{{ $i }}"/>
            </a>
        @endfor
    </div>

    <h1> Album 3</h1>

    @for( $i = 1; $i <= 4; $i++)
        <!-- Hidden video div -->
        <div style="display:none;" id="video{{ $i }}">
            <video class="lg-video-object lg-html5" controls preload="none">
                <source src="resources/videos/video{{ $i }}.mp4" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>
        </div>
    @endfor

    <!-- data-src should not be provided when you use html5 videos -->
    <div id="html5-videos">
        @for( $i = 1; $i <= 4; $i++)
            <a data-tweet-text="share on twitter {{ $i }}" data-poster="resources/videos/video-poster{{ $i }}.jpg" data-sub-html="video caption{{ $i }}" data-html="#video{{ $i }}" >
                <img src="resources/videos/thumb{{ $i }}.jpg" />
            </a>
        @endfor
    </div>
@endsection

@section('debug script')
    <script>
        $(function() {

            var $lightGallery = $('#lightgallery');
            var $lightGallery2 = $('#lightgallery2');
            var $lightGallery3 = $('#html5-videos');

            $lightGallery.lightGallery({
                subHtmlSelectorRelative: true,
                thumbnail: true,
                pinterest: false,
                googlePlus: false,
                galleryId: 1
            });


            $('#lightgallery2').lightGallery( {
                thumbnail: true,
                galleryId: 2
            });


            $lightGallery3.lightGallery({
                pinterest: false,
                googlePlus: false,
                zoom: false,
                autoplayControls: false,
                galleryId: 3
            });

        });
    </script>
@endsection


