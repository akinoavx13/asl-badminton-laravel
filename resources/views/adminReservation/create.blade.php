@extends('layout')

@section('title')
    Bloquer une réservation un jour
@stop

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            @include('adminReservation.form')
        </div>
    </div>
@stop