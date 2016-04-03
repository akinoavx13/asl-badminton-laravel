@extends('layout')

@section('title')
    Créer un tournoi
@stop

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            @include('tournament.form')
        </div>
    </div>
@stop
