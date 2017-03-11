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

@section('content')
    <div class="container-fluid">
        <div id="album" class="row text-center">
            <h1>Album 1</h1>
        </div>

        <div class="row text-center">
            <paginator></paginator>
        </div>

        <div class="row">
            <gallery path = '{{ public_user_path() }}'></gallery>
        </div>

        <div class="row text-center">
            <paginator></paginator>
        </div>

        <div id="scrollup" class="button" style="display: none;"></div>
    </div>
@endsection



