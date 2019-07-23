@extends('layout')

@section('title')
    Gestion du set
@stop

@section('content')

    <h1 class="text-center">Gestion du set de la section </h1>

    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">
                Les personnes qui s’en occupent le plus souvent sont :
            </h2>
            <div class="row">

            </div>
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                @foreach($biggestVolunteers as $index => $people)     
                                    <div class="text-center">          
                                        {{ $people->user->forname }} {{ $people->user->name }} : {{ $people->count }} fois
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <h1 class="text-center">Historique (30 derniers)</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped reservation">
            <thead>
            <tr>
                <th rowspan="1" class="text-center">Date</th>
                <th class="text-center">Volontaire</th>
            </tr>
            </thead>

            <tbody>
            @foreach($latestVolunteers as $index => $people) 
                <tr class="text-left">
                    <td rowspan="1" style="background: #fbfcfc;">
                        {{ $people->day }}
                    </td>
                    <td>
                        {{ $people->user->forname }} {{ $people->user->name }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@stop