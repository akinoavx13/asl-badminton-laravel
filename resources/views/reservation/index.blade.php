@extends('layout')

@section('title')
    Réservations
@stop

@section('content')

    <h1 class="text-center">
        Réserver un court
    </h1>

    <div class="row">
        <div class="col-md-offset-5 col-md-2">
            <a href="#{{ \Carbon\Carbon::today()->format('Y-m-d') }}" class="btn btn-primary btn-block">Voir les réservations d'aujourd'hui</a>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12">
            @if(count($timeSlots) > 0 || count($courts) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped reservation">
                        <thead>
                        <tr>
                            <th rowspan="{{ count($timeSlots) }}" class="text-center">Jour</th>
                            <th class="text-center">Crénaux</th>
                            @foreach($courts as $court)
                                <th class="text-center">{{ ucfirst($court->type) }} {{ $court }}</th>
                            @endforeach
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($allDays as $day)
                            <tr class="text-center">
                                <td rowspan="{{ count($timeSlots) }}" style="background: #fbfcfc;" id="{{
                                $day->format('Y-m-d') }}" class="{{ $day->format('Y-m-d') == \Carbon\Carbon::today()->format('Y-m-d') ? 'today' : '' }}">
                                    {{ ucfirst($day->format('l j F Y')) }}
                                </td>
                                <td>
                                    {{ $timeSlots[0] }}
                                </td>
                                @foreach($courts as $court)
                                    <td>
                                        @if(\Carbon\Carbon::today() > $day)
                                            <span class="fa fa-clock-o reservation-text-out"></span>
                                        @else
                                            <a href="{{ route('reservation.create', [$day->format('Y-m-d'), $court->id, $timeSlots[0]->id]) }}">Réserver</a>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            @if(count($timeSlots) > 1)
                                @foreach($timeSlots as $timeSlot)
                                    @if($timeSlot != $timeSlots[0])
                                        <tr class="text-center">
                                            <td>{{ $timeSlot }}</td>
                                            @foreach($courts as $court)
                                                <td>
                                                    @if(\Carbon\Carbon::today() > $day)
                                                        <span class="fa fa-clock-o reservation-text-out"></span>
                                                    @else
                                                        <a href="{{ route('reservation.create', [$day->format('Y-m-d'), $court->id, $timeSlot->id]) }}">Réserver</a>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h1 class="text-danger text-center">
                    Pas de réservation disponible pour le moment
                </h1>
            @endif
        </div>
    </div>

@stop