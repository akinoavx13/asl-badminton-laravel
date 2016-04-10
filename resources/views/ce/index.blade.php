@extends('layout')

@section('title')
    Budget
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger text-center">
                Les prix indiqués si dessous ne contiennent pas les 10 € de l'ASL !
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info text-center">
                {{ $totalPaid }} € payé sur un total de {{ $totalPayable }} €
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">
                Budget
            </h2>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <tbody>
                <tr>
                    <td>
                        <button type="button" class="btn btn-danger m-r-sm">{{ $tShirt['number'] }}</button>
                        <span>
                            @if($tShirt['number'] > 1)
                                t-shirts :
                            @else
                                t-shirt :
                            @endif
                            <span class="text-danger">{{ $tShirt['price'] }} €</span>
                        </span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary m-r-sm">{{ $leisure['number'] }}</button>
                        <span>
                            @if($leisure['number'] > 1)
                                formules
                            @else
                                formule
                            @endif
                            loisir : <span class="text-danger">{{ $leisure['price'] }} €</span>
                        </span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-info m-r-sm">{{ $fun['number'] }}</button>
                        <span>
                            @if($fun['number'] > 1)
                                formules
                            @else
                                formule
                            @endif
                            fun : <span class="text-danger">{{ $fun['price'] }} €</span>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="button" class="btn btn-info m-r-sm">{{ $performance['number'] }}</button>
                        <span>
                            @if($performance['number'] > 1)
                                formules
                            @else
                                formule
                            @endif
                            performance : <span class="text-danger">{{ $performance['price'] }} €</span>
                        </span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-success m-r-sm">{{ $competition['number'] }}</button>
                        <span>
                            @if($competition['number'] > 1)
                                formules
                            @else
                                formule
                            @endif
                            compétition : <span class="text-danger">{{ $competition['price'] }} €</span>
                        </span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger m-r-sm">{{ $corpo['number'] }}</button>
                        <span>
                            @if($corpo['number'] > 1)
                                formules
                            @else
                                formule
                            @endif
                            corpo : <span class="text-danger">{{ $corpo['price'] }} €</span>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="button" class="btn btn-primary m-r-sm">{{ $tournament['number'] }}</button>
                        <span>
                            @if($tournament['number'] > 1)
                                formules
                            @else
                                formule
                            @endif
                            tournoi : <span class="text-danger">{{ $tournament['price'] }} €</span>
                        </span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning m-r-sm">{{ $contributionUnPaid['number'] }}</button>
                        <span>
                            @if($contributionUnPaid['number'] > 1)
                                <span class="text-danger">cotisations non payées sur {{ count($players) }}</span>
                            @else
                                <span class="text-danger">cotisation non payée sur {{ count($players) }}</span>
                            @endif
                        </span>
                    </td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            @if(count($players) > 0)
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover display" id="ceList">
                                <thead>
                                <tr>
                                    <th class="text-center">Prénom</th>
                                    <th class="text-center">Nom</th>
                                    <th class="text-center">Contacter</th>
                                    <th class="text-center">Formule</th>
                                    <th class="text-center">T-shirt</th>
                                    <th class="text-center">Total à payer</th>
                                    <th class="text-center">Statut CE</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($players as $player)
                                    <tr>
                                        <td class="text-center">{{ $player->user->forname }}</td>
                                        <td class="text-center">{{ $player->user->name }}</td>
                                        <td class="text-center">
                                            <a href="mailto:{{ $player->user->email }}" class="btn btn-info"
                                               title="Envoyer un mail"><i class="fa fa-send"></i></a>
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
                                            @if($player->hasTShirt(true))
                                                <span class="fa fa-check-circle-o fa-2x text-success"
                                                      aria-hidden="true"><span hidden>t_shirt</span></span>
                                            @else
                                                <span class="fa fa-times-circle-o fa-2x text-danger"
                                                      aria-hidden="true"><span hidden>pas t_shirt</span></span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($player->hasCeState('contribution_payable'))
                                                <i class="text-danger">{{ $price = $player->getTotalPrice($setting) }}
                                                    €</i>
                                            @else
                                                <i class="text-navy">{{ $price = $player->getTotalPrice($setting) }}
                                                    €</i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($player->hasCeState('contribution_payable'))
                                                <a href="{{ route('player.ce_stateTocontribution_paid', $player->id) }}"
                                                   class="btn btn-success">Contribution à payer</a>
                                            @elseif($player->hasCeState('contribution_paid'))
                                                <i class="text-success">Contribution payée</i>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <h2 class="text-center text-danger">
                    Pas encore de joueur
                </h2>
            @endif
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#ceList').DataTable({
                "pageLength": 100,
                language: {
                    processing: "Traitement en cours...",
                    search: "Rechercher&nbsp;:",
                    lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
                    info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                    infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                    infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                    infoPostFix: "",
                    loadingRecords: "Chargement en cours...",
                    zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    emptyTable: "Aucune donnée disponible dans le tableau",
                    paginate: {
                        first: "Premier",
                        previous: "Pr&eacute;c&eacute;dent",
                        next: "Suivant",
                        last: "Dernier"
                    },
                    aria: {
                        sortAscending: ": activer pour trier la colonne par ordre croissant",
                        sortDescending: ": activer pour trier la colonne par ordre décroissant"
                    }
                }
            });
        });
    </script>
@stop