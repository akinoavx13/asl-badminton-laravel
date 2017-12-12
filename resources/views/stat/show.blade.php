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
        {{ $user }} a {{ $cumulStat['percentWin']}}% de victoire. </br>
        {{ $cumulStat['nbMatchWon'] }} matchs gagnés ({{ $cumulStat['nbMatchWonTwoSets']}} en 2 sets et {{ $cumulStat['nbMatchWonThreeSets']}} en 3 sets) </br>
        {{ $cumulStat['nbMatchLost'] }} matchs perdus ({{ $cumulStat['nbMatchLostTwoSets']}} en 2 sets et {{ $cumulStat['nbMatchLostThreeSets']}} en 3 sets) </br>

        En moyenne il gagne un match avec {{ $cumulStat['averageSetMatchWon'] }} sets d'avance (La différence de set pour les matchs gagnés est de {{ $cumulStat['diffSetMatchWon'] }}) </br>
        En moyenne il perd un match avec {{ $cumulStat['averageSetMatchLost'] }} sets de retard (La différence de set pour les matchs perdus est de {{ $cumulStat['diffSetMatchLost'] }}) </br>

        En moyenne il gagne un set avec {{ $cumulStat['averagePointSetWon'] }} points d'avance (La différence de point pour les sets {{ $cumulStat['nbSetWon'] }} gagnés est de {{ $cumulStat['diffPointSetWon'] }}) </br>
        En moyenne il perd un set avec {{ $cumulStat['averagePointSetLost'] }} points de retard (La différence de point pour les sets {{ $cumulStat['nbSetLost'] }} perdus est de {{ $cumulStat['diffPointSetLost'] }}) </br>

        Il a été forfait {{ $cumulStat['nbMyWO'] }} fois et ses adversaires {{ $cumulStat['nbHisWO'] }} fois. </br>
        Le nombre de match non joué est de {{ $cumulStat['nbUnplayed'] }}.
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
