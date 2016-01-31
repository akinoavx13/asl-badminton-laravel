@extends('layout')

@section('title')
    Ecrire un témoignage
@stop

@section('content')
    <div class="row">
        <div class="col-md-push-1 col-md-10">
            @include('testimonial.form')
        </div>
    </div>
@stop