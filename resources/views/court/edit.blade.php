@extends('layout')

@section('title')
    Modification du court n° {{ $court }}
@stop

@section('content')
    @include('court.form')
@stop