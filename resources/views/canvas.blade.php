<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">


    <link rel="stylesheet" href="css/lightgallery.css" />


    <!--
    <style type="text/css">
        body{
            background-color: #152836
        }
        .demo-gallery > ul {
            margin-bottom: 0;
        }
        .demo-gallery > ul > li {
            float: left;
            margin-bottom: 15px;
            margin-right: 20px;
            width: 200px;
        }
        .demo-gallery > ul > li a {
            border: 3px solid #FFF;
            border-radius: 3px;
            display: block;
            overflow: hidden;
            position: relative;
            float: left;
        }
        .demo-gallery > ul > li a > img {
            -webkit-transition: -webkit-transform 0.15s ease 0s;
            -moz-transition: -moz-transform 0.15s ease 0s;
            -o-transition: -o-transform 0.15s ease 0s;
            transition: transform 0.15s ease 0s;
            -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
            height: 100%;
            width: 100%;
        }
        .demo-gallery > ul > li a:hover > img {
            -webkit-transform: scale3d(1.1, 1.1, 1.1);
            transform: scale3d(1.1, 1.1, 1.1);
        }
        .demo-gallery > ul > li a:hover .demo-gallery-poster > img {
            opacity: 1;
        }
        .demo-gallery > ul > li a .demo-gallery-poster {
            background-color: rgba(0, 0, 0, 0.1);
            bottom: 0;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            -webkit-transition: background-color 0.15s ease 0s;
            -o-transition: background-color 0.15s ease 0s;
            transition: background-color 0.15s ease 0s;
        }
        .demo-gallery > ul > li a .demo-gallery-poster > img {
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
        .demo-gallery > ul > li a:hover .demo-gallery-poster {
            background-color: rgba(0, 0, 0, 0.5);
        }
        .demo-gallery .justified-gallery > a > img {
            -webkit-transition: -webkit-transform 0.15s ease 0s;
            -moz-transition: -moz-transform 0.15s ease 0s;
            -o-transition: -o-transform 0.15s ease 0s;
            transition: transform 0.15s ease 0s;
            -webkit-transform: scale3d(1, 1, 1);
            transform: scale3d(1, 1, 1);
            height: 100%;
            width: 100%;
        }
        .demo-gallery .justified-gallery > a:hover > img {
            -webkit-transform: scale3d(1.1, 1.1, 1.1);
            transform: scale3d(1.1, 1.1, 1.1);
        }
        .demo-gallery .justified-gallery > a:hover .demo-gallery-poster > img {
            opacity: 1;
        }
        .demo-gallery .justified-gallery > a .demo-gallery-poster {
            background-color: rgba(0, 0, 0, 0.1);
            bottom: 0;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            -webkit-transition: background-color 0.15s ease 0s;
            -o-transition: background-color 0.15s ease 0s;
            transition: background-color 0.15s ease 0s;
        }
        .demo-gallery .justified-gallery > a .demo-gallery-poster > img {
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
        .demo-gallery .justified-gallery > a:hover .demo-gallery-poster {
            background-color: rgba(0, 0, 0, 0.5);
        }
        .demo-gallery .video .demo-gallery-poster img {
            height: 48px;
            margin-left: -24px;
            margin-top: -24px;
            opacity: 0.8;
            width: 48px;
        }
        .demo-gallery.dark > ul > li a {
            border: 3px solid #04070a;
        }
        .home .demo-gallery {
            padding-bottom: 80px;
        }
    </style>
    -->

    <style>
        /*
                    a[data-tweet-text] {
                        border-style: solid;
                        border-width: 1px;
                        border-color: #000;
                    }
        */
    </style>



    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>

<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> Gallery </title>


        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">


        <!--
        <style type="text/css">
            body{
                background-color: #152836
            }
            .demo-gallery > ul {
                margin-bottom: 0;
            }
            .demo-gallery > ul > li {
                float: left;
                margin-bottom: 15px;
                margin-right: 20px;
                width: 200px;
            }
            .demo-gallery > ul > li a {
                border: 3px solid #FFF;
                border-radius: 3px;
                display: block;
                overflow: hidden;
                position: relative;
                float: left;
            }
            .demo-gallery > ul > li a > img {
                -webkit-transition: -webkit-transform 0.15s ease 0s;
                -moz-transition: -moz-transform 0.15s ease 0s;
                -o-transition: -o-transform 0.15s ease 0s;
                transition: transform 0.15s ease 0s;
                -webkit-transform: scale3d(1, 1, 1);
                transform: scale3d(1, 1, 1);
                height: 100%;
                width: 100%;
            }
            .demo-gallery > ul > li a:hover > img {
                -webkit-transform: scale3d(1.1, 1.1, 1.1);
                transform: scale3d(1.1, 1.1, 1.1);
            }
            .demo-gallery > ul > li a:hover .demo-gallery-poster > img {
                opacity: 1;
            }
            .demo-gallery > ul > li a .demo-gallery-poster {
                background-color: rgba(0, 0, 0, 0.1);
                bottom: 0;
                left: 0;
                position: absolute;
                right: 0;
                top: 0;
                -webkit-transition: background-color 0.15s ease 0s;
                -o-transition: background-color 0.15s ease 0s;
                transition: background-color 0.15s ease 0s;
            }
            .demo-gallery > ul > li a .demo-gallery-poster > img {
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
            .demo-gallery > ul > li a:hover .demo-gallery-poster {
                background-color: rgba(0, 0, 0, 0.5);
            }
            .demo-gallery .justified-gallery > a > img {
                -webkit-transition: -webkit-transform 0.15s ease 0s;
                -moz-transition: -moz-transform 0.15s ease 0s;
                -o-transition: -o-transform 0.15s ease 0s;
                transition: transform 0.15s ease 0s;
                -webkit-transform: scale3d(1, 1, 1);
                transform: scale3d(1, 1, 1);
                height: 100%;
                width: 100%;
            }
            .demo-gallery .justified-gallery > a:hover > img {
                -webkit-transform: scale3d(1.1, 1.1, 1.1);
                transform: scale3d(1.1, 1.1, 1.1);
            }
            .demo-gallery .justified-gallery > a:hover .demo-gallery-poster > img {
                opacity: 1;
            }
            .demo-gallery .justified-gallery > a .demo-gallery-poster {
                background-color: rgba(0, 0, 0, 0.1);
                bottom: 0;
                left: 0;
                position: absolute;
                right: 0;
                top: 0;
                -webkit-transition: background-color 0.15s ease 0s;
                -o-transition: background-color 0.15s ease 0s;
                transition: background-color 0.15s ease 0s;
            }
            .demo-gallery .justified-gallery > a .demo-gallery-poster > img {
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
            .demo-gallery .justified-gallery > a:hover .demo-gallery-poster {
                background-color: rgba(0, 0, 0, 0.5);
            }
            .demo-gallery .video .demo-gallery-poster img {
                height: 48px;
                margin-left: -24px;
                margin-top: -24px;
                opacity: 0.8;
                width: 48px;
            }
            .demo-gallery.dark > ul > li a {
                border: 3px solid #04070a;
            }
            .home .demo-gallery {
                padding-bottom: 80px;
            }
        </style>
        -->

        <style>
/*
            a[data-tweet-text] {
                border-style: solid;
                border-width: 1px;
                border-color: #000;
            }
*/
        </style>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Brand</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
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
                    </ul>
                    <form class="navbar-form navbar-left">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                                <button class="btn btn-default">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

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


        <script src="{{ mix('js/app.js') }}"></script>

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
    </body>
</html>


