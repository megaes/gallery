@extends('layouts.app')

@section('gallery navbar')
<li>
    <a href="#">
        <i class="fa fa-lg fa-upload" aria-hidden="true"></i>
        Upload
    </a>
</li>
<li is="album-selector"></li>
<li>
    <form class="navbar-form select2-tags">
        <div class="input-group select2-bootstrap-append">
            <select class="js-example-tags form-control" multiple="multiple">
                <option selected="selected">orange</option>
                <option>white</option>
                <option selected="selected">purple</option>
            </select>
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">Filter</button>
            </span>
        </div>
    </form>
</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row text-center">
            <album></album>
        </div>

        <div class="row text-center">
            <paginator></paginator>
        </div>

        <div class="row">
            <gallery></gallery>
        </div>

        <div class="row text-center">
            <paginator></paginator>
        </div>
    </div>
@endsection
