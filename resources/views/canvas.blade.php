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

    #light-gallery  > .grid-item {
        border: 2px solid rgb(255,255,255);
        overflow: hidden;
        padding: 0px;
        position: relative;
    }

    #light-gallery > .grid-item > .lazyload, #light-gallery  > .grid-item > .lazyloading {
        opacity: 0.0;
        position:absolute;

        width: 100%;
        height: auto;
    }

    #light-gallery  > .grid-item > .lazyloaded {
        opacity: 1.0;
        position:absolute;

        width: 100%;
        height: auto;

        -webkit-transition: -webkit-transform 0.5s ease 0s;
        -moz-transition: -moz-transform 0.5s ease 0s;
        -o-transition: -o-transform 0.5s ease 0s;
        transition: transform 0.5s ease 0s, opacity 1.0s ease 0s;
        -webkit-transform: scale3d(1.0, 1.0, 1.0);
        transform: scale3d(1.0, 1.0, 1.0);
    }


    #light-gallery  > .grid-item:hover > .lazyloaded {
        -webkit-transform: scale3d(1.1, 1.1, 1.1);
        transform: scale3d(1.1, 1.1, 1.1);
    }


    #light-gallery  > .grid-item:hover .demo-gallery-poster > i {
        opacity: 1.0;
    }

    #light-gallery > .grid-item .demo-gallery-poster {
        background-color: rgba(0, 0, 0, 0);
        bottom: 0;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        -webkit-transition: background-color 0.5s ease 0s;
        -o-transition: background-color 0.5s ease 0s;
        transition: background-color 0.5s ease 0s;
    }

    #light-gallery  > .grid-item .demo-gallery-poster > i {
        font-size: 24px;
        color: rgb( 255, 255, 255);
        left: 5%;
//        margin-left: -12px;
//        margin-top: -12px;
        opacity: 0;
        position: absolute;
        top: 5%;
        -webkit-transition: opacity 0.3s ease 0s;
        -o-transition: opacity 0.3s ease 0s;
        transition: opacity 0.3s ease 0s;
    }

    #light-gallery > .grid-item:hover .demo-gallery-poster {
        background-color: rgba(0, 0, 0, 0.6);
    }

    #scrollup {
        position: fixed;
        bottom: 5px;
        right: 7px;
        background: none;
        cursor: pointer;
    }

    #scrollup.button {
        display: block;
        height: 50px;
        width: 50px;
        z-index: 1000;
        display: none;
        background-image: url(data:image/png;base64,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);
    }

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

        <div id="light-gallery" class="row">
            @for ($i = 1, $n = 1; $i <= 1000; $i++, $n = max(1, ($n+1) % 17) )
                <div class="grid-item col-xs-6 col-sm-4 col-md-3 col-lg-2" data-tweet-text="Say something about this..." data-twitter-share-url="https://1drv.ms/i/s!AtbI7T-Zhxq1hEMvNwKaW6zZaLP_" data-facebook-share-url="https://1drv.ms/i/s!AtbI7T-Zhxq1hEMvNwKaW6zZaLP_" href="resources/img/{{ $n }}.jpg" data-sub-html=".caption">
                    <img class="lazyload" data-src="resources/img/tn-{{ $i }}.jpg" data-original="resources/img/{{ $i }}.jpg"> </img>

                    <div class="demo-gallery-poster">
                        <i class="glyphicon glyphicon-search"></i>
                    </div>
                    <div class="caption" style="display:none">
                        <h4>Bowness Bay</h4><p>A beautiful Sunrise this morning taken En-route to Keswick not one as planned but I'm extremely happy I was passing the right place at the right time....</p>
                    </div>
                    <div style="padding-top: 100%"></div>
                </div>
            @endfor
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
            <div style="display:none;" id="video{{ $i }}">
                <video class="lg-video-object lg-html5" controls preload="none">
                    <source src="resources/videos/video{{ $i }}.mp4" type="video/mp4">
                    Your browser does not support HTML5 video.
                </video>
            </div>
        endfor

        <!-- data-src should not be provided when you use html5 videos --
        <div class="light-gallery html5-videos row">
            for( $j = 1, $i = 1; $j <= 20; $j++, $i = rand(1, 4))
                <div class="grid-item col-xs-4 col-sm-3 col-md-2 col-lg-1" data-tweet-text="share on twitter {{ $i }}" data-poster="resources/videos/video-poster{{ $i }}.jpg" data-sub-html="video caption{{ $i }}" data-html="#video{{ $i }}" >
                    <img class="img-responsive" src="resources/videos/video-poster{{ $i }}.jpg" />
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

            var gallery = document.getElementById('light-gallery');

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


            $('.pagination > li').click( function(event, processIsotope = true) {
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


            var $lightGallery = $('#light-gallery');



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
                $("html, body").animate({
                    scrollTop: 0
                }, 1000 * $window.scrollTop() / $window.height());
            });
        });
    </script>
@endsection


