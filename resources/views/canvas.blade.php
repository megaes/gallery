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
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="disabled">
                        <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li id="pagination-page-1-up" class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li>
                        <a href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div id="gallery" class="row">
            @foreach($resources as $resource)
                <div class="grid-item col-xs-6 col-sm-4 col-md-3 col-lg-2" data-tweet-text="Say something about this..." data-twitter-share-url="https://1drv.ms/i/s!AtbI7T-Zhxq1hEMvNwKaW6zZaLP_" data-facebook-share-url="https://1drv.ms/i/s!AtbI7T-Zhxq1hEMvNwKaW6zZaLP_" href="{{ $resource->name }}" data-sub-html=".caption">

                    <img class="lazyload" data-src="{{ $resource->tn_name }}" data-original="{{ $resource->name }}"> </img>

                    <div class="demo-gallery-poster">
                        <i class="glyphicon glyphicon-search"></i>
                    </div>
                    <div class="caption" style="display:none">
                        <p>{{ $resource->caption }}</p>
                    </div>
                    <div style="padding-top: {{ $resource->tn_aspect_ratio }}%"></div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="disabled">
                        <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li id="pagination-page-1-down"  class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li>
                        <a href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <!--
        <div class="row">
            <h1> Album 3</h1>
        </div>
    <!--
        for( $j = 1, $i = 1; $j <= 20; $j++, $i = rand(1, 4))
            <!-- Hidden video div --
            <div style="display:none;" id="video{ $i }"light-gallery     <video class="lg-video-object lg-html5" controls preload="none">
                    <source src="resources/videos/video{ $i }.mp4" type="video/mp4">
                    Your browser does not support HTML5 video.
                </video>
            </div>
        endfor

        <!-- data-src should not be provided when you use html5 videos --
        <div class="light-gallery html5-videos row">
            for( $j = 1, $i = 1; $j <= 20; $j++, $i = rand(1, 4))
                <div class="grid-item col-xs-4 col-sm-3 col-md-2 col-lg-1" data-tweet-text="share on twitter { $i }" data-poster="resources/videos/video-poster{ $i }.jpg" data-sub-html="video caption{ $i }" data-html="#video{ $i }" >
                    <img class="img-responsive" src="resources/videos/video-poster{ $i }.jpg" />
                    <div class="demo-gallery-poster">
                        <i class="glyphicon glyphicon-search"></i>
                    </div>
                </div>
            endfor
        </div>
        -->
        <div id="scrollup" class="button" style="display: none;"></div>
    </div>
@endsection

@section('debug script')

    <script>
        $(function() {
            console.log(devicePixelRatio);

            var gallery = document.getElementById('gallery');

            var isotope = new Isotope( gallery, {
                itemSelector: '.grid-item',
                layoutMode: 'masonry',
                percentPosition: true
            });

            (function() {
                var counter = 0;
                isotope.arrange({
                    filter: function() {
                        return (counter++ >= 0) && (counter < 200);
                    }
                });
            })();


            $('.pagination > li').click( function(event) {
                event.preventDefault();

                var children = this.parentNode.children;
                var last = children.length - 1;
                var activeID=0;
                var clickedID=0;

                for(var i=0; i<children.length; i++) {
                  if(children[i].classList.contains('active')) {
                      activeID = i;
                  }
                  if(children[i] == this) {
                    clickedID = i;
                  }
                }

                if(clickedID == 0) {
                    clickedID = activeID - 1;
                } else if(clickedID == last) {
                    clickedID = activeID + 1;
                }

                if((activeID == clickedID) || (clickedID == 0) || (clickedID == last)) {
                    return;
                }

                children[activeID].classList.remove('active');
                children[clickedID].classList.add('active');

                if(clickedID == last - 1) {
                    children[last].classList.add('disabled');
                }
                if(clickedID == 1) {
                    children[0].classList.add('disabled');
                }

                if(children[0].classList.contains('disabled') && (clickedID > 1)) {
                    children[0].classList.remove('disabled');
                }
                if(children[last].classList.contains('disabled') && (clickedID < last - 1)) {
                    children[last].classList.remove('disabled');
                }

                var min = (clickedID - 1)*200;
                var max = clickedID * 200;
                var counter = 0;
                isotope.arrange({
                    filter: function() {
                        var result = (counter++ >= min) && (counter < max);
                        return result;
                    }
                });
            });


//            $('#pagination-page-1-up').trigger('click');

            lazySizes.init();


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


