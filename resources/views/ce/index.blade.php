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
                        @if($tShirt['number'] > 1)
                            t-shirts :
                        @else
                            t-shirt :
                        @endif
                        <i class="text-danger">{{ $tShirt['price'] }} €</i>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary m-r-sm">{{ $leisure['number'] }}</button>
                        @if($leisure['number'] > 1)
                            formules
                        @else
                            formule
                        @endif
                        loisir : <i class="text-danger">{{ $leisure['price'] }} €</i>
                    </td>
                    <td>
                        <button type="button" class="btn btn-info m-r-sm">{{ $fun['number'] }}</button>
                        @if($fun['number'] > 1)
                            formules
                        @else
                            formule
                        @endif
                        fun : <i class="text-danger">{{ $fun['price'] }} €</i>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="button" class="btn btn-info m-r-sm">{{ $performance['number'] }}</button>
                        @if($performance['number'] > 1)
                            formules
                        @else
                            formule
                        @endif
                        performance : <i class="text-danger">{{ $performance['price'] }} €</i>
                    </td>
                    <td>
                        <button type="button" class="btn btn-success m-r-sm">{{ $competition['number'] }}</button>
                        @if($competition['number'] > 1)
                            formules
                        @else
                            formule
                        @endif
                        compétition : <i class="text-danger">{{ $competition['price'] }} €</i>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger m-r-sm">{{ $corpo['number'] }}</button>
                        @if($corpo['number'] > 1)
                            formules
                        @else
                            formule
                        @endif
                        corpo : <i class="text-danger">{{ $corpo['price'] }} €</i>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="button"
                                class="btn btn-warning m-r-sm">{{ $contributionUnPaid['number'] }}</button>
                        @if($contributionUnPaid['number'] > 1)
                            <i class="text-danger">cotisations non payées sur {{ count($players) }}</i>
                        @else
                            <i class="text-danger">cotisation non payée sur {{ count($players) }}</i>
                        @endif
                    </td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
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
                                                  aria-hidden="true"></span>
                                        @else
                                            <span class="fa fa-times-circle-o fa-2x text-danger"
                                                  aria-hidden="true"></span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($player->hasCeState('contribution_payable'))
                                            <i class="text-danger">{{ $price = $player->getTotalPrice($setting) }} €</i>
                                        @else
                                            <i class="text-navy">{{ $price = $player->getTotalPrice($setting) }} €</i>
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
        </div>
    </div>
@stop