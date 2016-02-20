@extends('layout')

@section('title')
    Envoyer un mail au développeur
@stop

@section('content')
    <div class="row">
        <div class="col-md-push-1 col-md-10">
            @include('emailToDev.form')
        </div>
    </div>
@stop