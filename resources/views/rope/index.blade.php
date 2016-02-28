@extends('layout')

@section('title')
    Cordage
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">
                @if($rest > 0)
                    Il reste <span class="text-navy">{{ $rest }}</span> cordage{{ $rest > 1 ? 's' : '' }}
                    <hr>
                    <div class="row">
                        <div class="col-md-offset-4 col-md-4">
                            <a href="{{ route('rope.withdrawal') }}" class="btn btn-primary"><span class="fa fa-shopping-cart"></span>
                                Envoyer une demande de cordage</a>
                        </div>
                    </div>
                @else
                    <span class="text-danger">
                        Il n'y a plus de cordage
                    </span>
                @endif
            </h1>
        </div>
    </div>

@stop