@extends('layout')

@section('title')
    Modification du créneau {{ $timeSlot }}
@stop

@section('content')
    @include('timeSlot.form')
@stop