@extends('layouts.app')

@section('gallery navbar')
<li is="uploader"></li>
<li is="album-selector"></li>
<li is="tag-selector"></li>
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
