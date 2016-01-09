@extends('layout')

@section('title')
    Modification de {{ $season }}
@stop

@section('content')
    <div class="row">
        <div class="col-md-push-1 col-md-10">
            @include('season.form')
        </div>
    </div>
@stop