@extends('layout')

@section('title')
    Statistiques de {{ $user }}
@stop

@section('content')

<div class="panel {{ $type == 'simple' ? 'panel-warning' : '' }} {{ $type == 'double' ? 'panel-info' : '' }} {{ $type == 'mixte' ? 'panel-danger' : '' }}">
    <div class="panel-heading">
        <h1 class="text-center">Résultat en simple</h1>
    </div>
    <div class="panel-body">
        {{ $user }} a gagné {{ $cumulStat['nbWin'] }} et perdu {{ $cumulStat['nbLost'] }} matchs soit {{ $cumulStat['percentWin']}}% de victoire. </br>
        La différence de set est de {{ $cumulStat['nbSet'] }} et de points de {{ $cumulStat['nbPoint'] }} </br>
        Le nombre de forfait est de {{ $cumulStat['nbMyWO'] }} (et forfait de l'adversaire {{ $cumulStat['nbHisWO'] }}) </br>
        Le nombre de match non joué est de {{ $cumulStat['nbUnplayed'] }}
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th class="text-center">Date</th>
                <th class="text-center">Équipe</th>
                <th class="text-center">Premier set</th>
                <th class="text-center">Deuxième set</th>
                <th class="text-center">Troisième set</th>
                <th class="text-center">Mon forfait</th>
                <th class="text-center">Son forfait</th>
                <th class="text-center">Joué</th>
            </tr>
            </thead>
            <tbody>
            @foreach($results as $result)
                <tr class="text-center">
                    <td>
                        {{$result['date'] }}
                    </td>
                    <td>
                        @if($result['firstTeamWin'])
                            <span class="btn btn-primary btn-rounded">
                                {{ $result['firstTeam'] }}
                            </span>
                        @else
                            {{ $result['firstTeam'] }}
                        @endif
                        <span class="font-bold text-info"> VS </span>
                        @if($result['secondTeamWin'])
                            <span class="btn btn-primary btn-rounded">
                            {{ $result['secondTeam'] }}
                        </span>
                        @else
                            {{ $result['secondTeam'] }}
                        @endif
                    </td>
                    <td>{{ $result['first_set_first_team'] }} / {{ $result['first_set_second_team'] }}</td>
                    <td>{{ $result['second_set_first_team'] }} / {{ $result['second_set_second_team'] }}</td>
                    <td>
                        @if($result['third_set_first_team'] == null && $result['third_set_second_team'] == null)
                            <span class="fa fa-times text-danger"></span>
                        @else
                            {{ $result['third_set_first_team'] }} / {{ $result['third_set_second_team'] }}
                        @endif
                    </td>
                    <td>
                        @if($result['my_wo'])
                            <span class="fa fa-check text-info"></span>
                        @else
                            <span class="fa fa-times text-danger"></span>
                        @endif
                    </td>
                    <td>@if($result['his_wo'])
                            <span class="fa fa-check text-info"></span>
                        @else
                            <span class="fa fa-times text-danger"></span>
                        @endif
                    </td>
                    <td>@if($result['unplayed'])
                            <span class="fa fa-times text-danger"></span>
                        @else
                            <span class="fa fa-check text-info"></span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop
