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



@endsection


@section('content')
    <div class="container-fluid">
        <div id="album" class="row">
            <h1> Album 1</h1>
        </div>

        <div class="row">
            <paginator></paginator>
        </div>

        <div class="row">
            <gallery path = '{{ $path }}' data = '{!! json_encode($frames) !!}'></gallery>
        </div>

        <div class="row">
            <paginator></paginator>
        </div>

        <div id="scrollup" class="button" style="display: none;"></div>
    </div>
@endsection

@section('debug script')

    <script>
        $(function() {

            var $lightGallery = $('#gallery');

            $('.demo-gallery-poster .glyphicon').click( function() {
                $lightGallery.lightGallery({
                    dynamic: true,
                    index: 2,
                    thumbnail: true,
                    share: false,
                    dynamicEl: [{
                        "src": 'resources/img/1.jpg',
                        'thumb': 'resources/img/tn-1.jpg',
                        'subHtml': '<h4>Fading Light</h4><p>Classic view from Rigwood Jetty on Coniston Water an old archive shot similar to an old post but a little later on.</p>'
                    }, {
                        "src": 'resources/img/2.jpg',
                        'thumb': 'resources/img/tn-2.jpg',
                        'data-twitter-share-url': "https://1drv.ms/i/s!AtbI7T-Zhxq1hEMvNwKaW6zZaLP_",
                        'subHtml': "<h4>Bowness Bay</h4><p>A beautiful Sunrise this morning taken En-route to Keswick not one as planned but I'm extremely happy I was passing the right place at the right time....</p>"
                    }, {
                        "src": 'resources/img/3.jpg',
                        'thumb': 'resources/img/tn-3.jpg',
                        'data-twitter-share-url': "https://1drv.ms/i/s!AtbI7T-Zhxq1hEMvNwKaW6zZaLP_",
                        'subHtml': "<h4>Coniston Calmness</h4><p>Beautiful morning</p>"
                    }]
                });
                $lightGallery.one("onCloseAfter.lg", function() {
                    var data = $lightGallery.data('lightGallery');
                    $lightGallery.data('lightGallery').destroy(true);
                });
            });

/*
                $(this).lightGallery({
                    subHtmlSelectorRelative: true,
                    thumbnail: true,
                    pinterest: false,
                    googlePlus: false,
                    galleryId: index + 1
                });
*/

/*
            $('.light-gallery.html5-videos').each( function(index) {
                var iso = new Isotope( this, {
                    initLayout: false,
                    itemSelector: '.grid-item',
                    percentPosition: true
                });

                imagesLoaded( this, function() {
                    iso.layout();
                });

                $(this).lightGallery({
                    pinterest: false,
                    googlePlus: false,
                    zoom: false,
                    autoplayControls: false,
                    galleryId: 3
                });
            });
*/
            $window = $(window);

            $window.scroll(function() {
                if ($window.scrollTop() > 100) {
                    $('#scrollup').fadeIn();
                } else {
                    $('#scrollup').fadeOut();
                }
            });

            $('#scrollup').click(function() {
                $('html,body').scrollTop(0);
                /*
                $("html, body").animate({
                    scrollTop: 0
                }, 0.5 * 1000 * $window.scrollTop() / $window.height());
                */
            });
        });
    </script>
@endsection


