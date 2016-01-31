@extends('layout')

@section('title')
    Témoignages
@stop

@section('content')

    <h1 class="text-center">Témoignages</h1>

    <div class="row">
        <div class="col-md-offset-4 col-md-4">
            <a href="{{ route('testimonial.create') }}" class="btn btn-primary btn-block">Ecrire un témoignage</a>
        </div>
    </div>

    <hr>

    @if(count($testimonials) > 0)

        <div class="row">
            @foreach($testimonials as $testimonial)
                <div class="col-md-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>{{ $testimonial->forname }} {{ $testimonial->name }}</h5>
                        </div>
                        <div class="ibox-content">
                            {!! $testimonial->content !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center">
            {!! $testimonials->render() !!}
        </div>

    @else
        <h2 class="text-center text-danger">Pas encore de témoignage, soyez le premier !</h2>
    @endif
@stop