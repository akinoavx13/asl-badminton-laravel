@extends('layout')

@section('title')
    Modification du créneau {{ $timeSlot }}
@stop

@section('content')
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            @include('timeSlot.form')
        </div>
    </div>
@stop