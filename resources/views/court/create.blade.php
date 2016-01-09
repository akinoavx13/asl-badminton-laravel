@extends('layout')

@section('title')
    Création d'un court
@stop

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            @include('court.form')
        </div>
    </div>
@stop