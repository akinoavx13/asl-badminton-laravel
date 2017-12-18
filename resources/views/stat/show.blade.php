@extends('layout')

@section('title')
    Statistiques de {{ $user }}
@stop

@section('content')

<div class="panel {{ $type == 'simple' ? 'panel-warning' : '' }} {{ $type == 'double' ? 'panel-info' : '' }} {{ $type == 'mixte' ? 'panel-danger' : '' }}">
    <div class="panel-heading">
        <h1 class="text-center">Statistiques en simple de {{ $user }}</h1>
    </div>
    <div class="panel-body">

      <div class="col-lg-3">
        <ul class="stat-list">
          <li>
              <h2 class="no-margins">{{ $cumulStat['nbMatchWonTwoSets']}}/{{ $cumulStat['nbMatchTotal']}}</h2>
              <small>Matchs gagnés en deux sets</small>
              <div class="stat-percent">{{  (int)(0.5 + 100* $cumulStat['nbMatchWonTwoSets']/ $cumulStat['nbMatchTotal'])}}% <i class="fa fa-bolt text-navy"></i></div>
              <div class="progress progress-mini">
                  <div style="width: {{ 100* $cumulStat['nbMatchWonTwoSets']/ $cumulStat['nbMatchTotal']}}%;" class="progress-bar"></div>
              </div>
          </li>
          <li>
              <h2 class="no-margins ">{{ $cumulStat['nbMatchWonThreeSets']}}/{{ $cumulStat['nbMatchTotal']}}</h2>
              <small>Matchs gagnés en trois sets</small>
              <div class="stat-percent">{{ (int) (0.5 + 100* $cumulStat['nbMatchWonThreeSets'] / $cumulStat['nbMatchTotal'])}}% <i class="fa fa-bolt text-navy"></i></div>
              <div class="progress progress-mini">
                  <div style="width: {{ 100* $cumulStat['nbMatchWonThreeSets'] / $cumulStat['nbMatchTotal']}}%;" class="progress-bar progress-bar-info"></div>
              </div>
          </li>
          <li>
              <h2 class="no-margins ">{{ $cumulStat['nbMatchLostThreeSets']}}/{{ $cumulStat['nbMatchTotal']}}</h2>
              <small>Matchs perdus en trois sets</small>
              <div class="stat-percent">{{ (int) (0.5 + 100 * $cumulStat['nbMatchLostThreeSets'] / $cumulStat['nbMatchTotal'])}}% <i class="fa fa-bolt text-navy"></i></div>
              <div class="progress progress-mini">
                  <div style="width: {{ 100 * $cumulStat['nbMatchLostThreeSets'] / $cumulStat['nbMatchTotal']}}%;" class="progress-bar progress-bar-warning"></div>
              </div>
          </li>
          <li>
              <h2 class="no-margins ">{{ $cumulStat['nbMatchLostTwoSets']}}/{{ $cumulStat['nbMatchTotal']}}</h2>
              <small>Matchs perdus en deux sets</small>
              <div class="stat-percent">{{ (int) (0.5 + 100 * $cumulStat['nbMatchLostTwoSets'] / $cumulStat['nbMatchTotal'])}}% <i class="fa fa-bolt text-navy"></i></div>
              <div class="progress progress-mini">
                  <div style="width: {{ 100 * $cumulStat['nbMatchLostTwoSets'] / $cumulStat['nbMatchTotal']}}%;" class="progress-bar progress-bar-danger"></div>
              </div>
          </li>

          </ul>
      </div>

      <div class="col-lg-3">
        <canvas id="myChart" class="chartjs" width="320" height="160" style="display: block; width: 320px; height: 160px;"></canvas>
        <h2 class="text-center">{{ $cumulStat['percentWin'] }}% de Victoire</h2>
        <h3 class="text-center">{{ $cumulStat['nbMyWO'] }}<small> Forfaits déclarés</small></h3>
        <h3 class="text-center">{{ $cumulStat['nbHisWO'] }}<small> Forfaits reçus</small></h3>
        <h3 class="text-center">{{ $cumulStat['nbUnplayed'] }}<small> Non joués</small></h3>
      </div>

<div class="col-lg-3">
  <h3>Les adversaires battus sont </h3>
@foreach($opponentsWon as $opponentWon => $nbMatch)
  - <a href="{{ route('stat.show', $opponentID[$opponentWon]) }}">{{ $opponentWon}}</a> battu {{ $nbMatch }} fois </br>
@endforeach
</div>

<div class="col-lg-3">
  <h3>Les adversaires vainqueurs sont </h3>
@foreach($opponentsLost as $opponentLost => $nbMatch)
  - <a href="{{ route('stat.show', $opponentID[$opponentLost]) }}">{{ $opponentLost}}</a> vainqueur {{ $nbMatch }} fois </br>
@endforeach
</div>

<div class="col-lg-12">
  <canvas id="lineChart" class="chartjs" height="150" style="display: block; width: 575px; height: 268px;" width="575"></canvas>
</div>


<div class="col-lg-12">
  <h2>Historique des matchs</h2>
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
</div>

@stop


@section('javascript')
<script>

var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'doughnut',

    // The data for our dataset
    data: {
        labels: ["Gagné", "Perdu"],
        datasets: [{
            label: "My First dataset",
            backgroundColor: ["#1ab394", "#f5f5f5"],
            borderColor: '#f5f5f5',
            data: [{{ $cumulStat['nbMatchWonTwoSets'] + $cumulStat['nbMatchWonThreeSets']}} ,{{ $cumulStat['nbMatchLostTwoSets'] + $cumulStat['nbMatchLostThreeSets']}}],
        }]
    },

    // Configuration options go here
    options: {
      rotation: -Math.PI,
      circumference: Math.PI,
      "legend": {display: false}
    }
});

var myBarChart = new Chart(
  document.getElementById("lineChart"),{
    "type":"bar",
    "data":{
      "labels": [
      @foreach($setsOpponent as $opponentName)
      "{{$opponentName}}",
      @endforeach
      ""
    ],
      "datasets":[{
        "label":"Différence de point par set",
        "data":[
        @foreach($setsDiffPoint as $diffPoint)
        "{{$diffPoint}}",
        @endforeach
        ""
      ],
        "fill":false,
        "backgroundColor":[
          @foreach($setsBackgroundColor as $backgroundColor)
          "{{$backgroundColor}}",
          @endforeach
          ""
        ],
        "borderColor":[
          @foreach($setsBorderColor as $borderColor)
          "{{$borderColor}}",
          @endforeach
          ""
        ],
        "borderWidth":3}]},
      "options":{
        "scales":{
          "xAxes":[{"ticks":{"display":false}
            }],
          "yAxes":[{
            "ticks":{
              "beginAtZero":true,
              "Max":21,
              "Min":-21,
              "stepSize":5
            }}]},
        "legend": {display: false}
      }
    });


</script>

@stop
