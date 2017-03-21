<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ mix('/css/all.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>
</head>
<body style="padding-top: 60px; overflow-y: scroll;">
    <div id="app">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar top-bar"></span>
                        <span class="icon-bar middle-bar"></span>
                        <span class="icon-bar bottom-bar"></span>
                    </button>

                    @if (Auth::guest())
                        <div class="navbar-brand">
                            {{ config('app.name') }}
                        </div>
                    @endif
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-left">
                        @yield('gallery navbar')
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li>
                                <a href="{{ route('login') }}">
                                    <i class="fa fa-lg fa-sign-in" aria-hidden="true"></i>
                                    Login
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}">
                                    <i class="fa fa-lg fa-user" aria-hidden="true"></i>
                                    Register
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); $('#logout-form').submit();">
                                    <i class="fa fa-lg fa-sign-out" aria-hidden="true"></i>
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}"></script>
    <script>
        $(".js-example-tags").select2({
            tags: true,
            width: ''
        })
    </script>
</body>
</html>
