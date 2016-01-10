@extends('layout')

@section('title')
    Réservation d'un court
@stop

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            @include('reservation.form')
        </div>
    </div>
@stop