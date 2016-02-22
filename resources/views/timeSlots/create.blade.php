@extends('layout')

@section('title')
    Création d'un crénaux
@stop

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            @include('timeSlot.form')
        </div>
    </div>
@stop