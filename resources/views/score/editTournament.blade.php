@extends('layout')

@section('title')
    Rentrer un score
@stop

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            @include('score.formTournament')
        </div>
    </div>
@stop