@extends('layout')

@section('title')
    Créer un championnat
@stop

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            @include('championship.form')
        </div>
    </div>
@stop