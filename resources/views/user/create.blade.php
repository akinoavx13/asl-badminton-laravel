@extends('layout')

@section('title')
    Création d'un utilisateur
@stop

@section('content')
    <div class="row">
        <div class="col-md-push-1 col-md-10">
            @include('user.form')
        </div>
    </div>
@stop