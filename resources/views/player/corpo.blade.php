@extends('layout')

@section('title')
    Liste des joueurs
@stop

@section('content')


    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Choisir une saison</h1>

            {!! Form::open(['route' => 'player.corpo', 'class' => 'form-horizontal']) !!}

            <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    {!! Form::select('season_id', $seasons, $season !== null ? $season->id : null,['class' => 'chosen-select', 'style' => 'width: 100%;']) !!}
                </div>
            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-success">
                    Choisir cette saison
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    @if($season !== null)
        <hr>

        <h1 class="text-center">Liste des joueurs en {{ $season }}</h1>

        <hr>

        @if(count($players) > 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover display" id="playerList">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Prénom</th>
                                        <th class="text-center">Nom</th>
                                        <th class="text-center">Sexe</th>
                                        <th class="text-center">H/D</th>
                                        <th class="text-center">Eq H/D</th>
                                        <th class="text-center">Mixte</th>
                                        <th class="text-center">Eq Mixte</th>
                                        <th class="text-center">Formule</th>
                                        <th class="text-center">Statut GBC</th>
                                        <th class="text-center">Certif.</th>
                                        <th class="text-center">Certif. N-1</th>
                                        <th class="text-center">Certif. N-2</th>
                                        <th class="text-center">Polo</th>
                                        <th class="text-center">Commentaire</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @foreach($players as $player)
                                        <tr>
                                            <td class="text-center">{{ $player->user->forname }}</td>
                                            <td class="text-center">{{ $player->user->name }}</td>
                                            <td class="text-center">
                                                @if($player->user->hasGender('man'))
                                                    Homme
                                                @elseif($player->user->hasGender('woman'))
                                                    Femme
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($player->user->hasGender('man'))
                                                    @if($player->hasCorpoMan(true))
                                                        <span class="fa fa-check-circle-o fa-2x text-success"
                                                              aria-hidden="true"><span hidden>corpoMan</span></span>
                                                    @elseif($player->hasCorpoMan(false))
                                                        <span class="fa fa-times-circle-o fa-2x text-danger"
                                                              aria-hidden="true"><span hidden>pas corpoMan</span></span>
                                                    @endif
                                                @elseif($player->user->hasGender('woman'))
                                                    @if($player->hasCorpoWoman(true))
                                                        <span class="fa fa-check-circle-o fa-2x text-success"
                                                              aria-hidden="true"><span hidden>corpoWoman</span></span>
                                                    @elseif($player->hasCorpoWoman(false))
                                                        <span class="fa fa-times-circle-o fa-2x text-danger"
                                                              aria-hidden="true"><span hidden>pas corpoWoman</span></span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($player->corpo_team == 0)
                                                    <a href="{{ route('player.changeCorpoTeam', $player->id) }}"
                                                       class="btn btn-danger">{{ $player->corpo_team}}</a>
                                                @elseif ($player->corpo_team == 1)
                                                    <a href="{{ route('player.changeCorpoTeam', $player->id) }}"
                                                       class="btn btn-success">{{ $player->corpo_team}}</a>
                                                @elseif ($player->corpo_team == 2)
                                                    <a href="{{ route('player.changeCorpoTeam', $player->id) }}"
                                                       class="btn btn-primary">{{ $player->corpo_team}}</a>
                                                @elseif ($player->corpo_team > 2)
                                                    <a href="{{ route('player.changeCorpoTeam', $player->id) }}"
                                                       class="btn btn-warning">{{ $player->corpo_team}}</a>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($player->hasCorpoMixte(true))
                                                    <span class="fa fa-check-circle-o fa-2x text-success"
                                                          aria-hidden="true"><span hidden>corpoMixte</span></span>
                                                @elseif($player->hasCorpoMixte(false))
                                                    <span class="fa fa-times-circle-o fa-2x text-danger"
                                                          aria-hidden="true"><span hidden>pas corpoMixte</span></span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($player->corpo_team_mixte == 0)
                                                    <a href="{{ route('player.changeCorpoTeamMixte', $player->id) }}"
                                                       class="btn btn-danger">{{ $player->corpo_team_mixte}}</a>
                                                @elseif ($player->corpo_team_mixte == 1)
                                                    <a href="{{ route('player.changeCorpoTeamMixte', $player->id) }}"
                                                       class="btn btn-success">{{ $player->corpo_team_mixte}}</a>
                                                @elseif ($player->corpo_team_mixte == 2)
                                                    <a href="{{ route('player.changeCorpoTeamMixte', $player->id) }}"
                                                       class="btn btn-primary">{{ $player->corpo_team_mixte}}</a>
                                                @elseif ($player->corpo_team_mixte > 2)
                                                    <a href="{{ route('player.changeCorpoTeamMixte', $player->id) }}"
                                                       class="btn btn-warning">{{ $player->corpo_team_mixte}}</a>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($player->hasFormula('leisure'))
                                                    Loisir
                                                @elseif($player->hasFormula('tournament'))
                                                    Tournoi
                                                @elseif($player->hasFormula('fun'))
                                                    Fun
                                                @elseif($player->hasFormula('performance'))
                                                    Performance
                                                @elseif($player->hasFormula('corpo'))
                                                    Corpo
                                                @elseif($player->hasFormula('competition'))
                                                    Competition
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($player->hasGbcState('non_applicable'))
                                                    <a href="{{ route('player.gbc_stateTocontribution_paid', $player->id) }}"
                                                       class="btn btn-danger">Non applicable</a>
                                                @elseif($player->hasGbcState('entry_must'))
                                                    <a href="{{ route('player.gbc_stateTocontribution_paid', $player->id) }}"
                                                       class="btn btn-warning">Dossier à remettre</a>
                                                @elseif($player->hasGbcState('valid'))
                                                    <a href="{{ route('player.gbc_stateTocontribution_paid', $player->id) }}"
                                                       class="btn btn-success">Attente licence</a>
                                                @elseif($player->hasGbcState('licence'))
                                                    <a href="{{ route('player.gbc_stateTocontribution_paid', $player->id) }}"
                                                       class="btn btn-primary">Licence à jour</a>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($player->certificate == 'questionnaire')
                                                    <a href="{{ route('player.changeCertificate', $player->id) }}"
                                                       class="btn btn-warning">Q</a>
                                                @elseif ($player->certificate == 'certificate')
                                                    <a href="{{ route('player.changeCertificate', $player->id) }}"
                                                       class="btn btn-primary">CM</a>
                                                @elseif ($player->certificate == '')
                                                    <a href="{{ route('player.changeCertificate', $player->id) }}"
                                                       class="btn btn-danger">??</a>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($certificates1[$player->id] == 'questionnaire')
                                                    <span class="btn btn-warning">Q</span>
                                                @elseif($certificates1[$player->id] == 'certificate')
                                                    <span class="btn btn-primary">CM</span>
                                                @elseif ($certificates1[$player->id] == '')
                                                    <span class="btn btn-danger">??</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($certificates2[$player->id] == 'questionnaire')
                                                    <span class="btn btn-warning">Q</span>
                                                @elseif($certificates2[$player->id] == 'certificate')
                                                    <span class="btn btn-primary">CM</span>
                                                @elseif ($certificates2[$player->id] == '')
                                                    <span class="btn btn-danger">??</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($player->polo_delivered == 'to_order')
                                                    <a href="{{ route('player.changePoloDelivered', $player->id) }}"
                                                       class="btn btn-danger">A commander</a>
                                                @elseif ($player->polo_delivered == 'to_deliver')
                                                    <a href="{{ route('player.changePoloDelivered', $player->id) }}"
                                                       class="btn btn-success">A livrer</a>
                                                @elseif ($player->polo_delivered == 'done')
                                                    <a href="{{ route('player.changePoloDelivered', $player->id) }}"
                                                       class="btn btn-primary">Livré</a>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {!! Form::open(['route' => 'player.updateComment', 'class' => 'form-horizontal', 'files' => 'false']) !!}
                                                {!! Form::text('corpoComment', $player->corpo_comment, ['class' => 'form-control', 'required']) !!}
                                                {!! Form::hidden('playerId', $player->id, ['class' => 'form-control', 'required']) !!}
                                                {!! Form::submit('OK', ['class' => 'btn btn-info']) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else

            <h2 class="text-center text-danger">Pas de joueur</h2>

        @endif
    @endif
@stop

@section('javascript')
    <script type="text/javascript">
        $(".chosen-select").chosen();

        $(document).ready(function() {
            $('#playerList').DataTable( {
                "pageLength": 100,
                language: {
                    processing:     "Traitement en cours...",
                    search:         "Rechercher&nbsp;:",
                    lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
                    info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                    infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                    infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                    infoPostFix:    "",
                    loadingRecords: "Chargement en cours...",
                    zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    emptyTable:     "Aucune donnée disponible dans le tableau",
                    paginate: {
                        first:      "Premier",
                        previous:   "Pr&eacute;c&eacute;dent",
                        next:       "Suivant",
                        last:       "Dernier"
                    },
                    aria: {
                        sortAscending:  ": activer pour trier la colonne par ordre croissant",
                        sortDescending: ": activer pour trier la colonne par ordre décroissant"
                    }
                }
            } );
        } );
    </script>
@stop
