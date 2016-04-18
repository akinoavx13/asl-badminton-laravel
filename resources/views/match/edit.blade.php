@extends('layout')

@section('title')
    Modification d'un match
@stop

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            @include('match.form')
        </div>
    </div>
@stop