@extends('layout')

@section('title')
    Liste des joueurs
@stop

@section('content')


    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Choisir une saison</h1>

            {!! Form::open(['route' => 'player.index', 'class' => 'form-horizontal']) !!}
            {!! Form::token() !!}

            <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    {!! Form::select('season_id', $seasons, $season_id !== null ? $season_id : null,['class' => 'chosen-select', 'style' => 'width: 320px;']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4 col-md-offset-5">
                    <button type="submit" class="btn btn-success">
                        Choisir cette saison
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    @if($season_id !== null)
        <hr>

        <h1 class="text-center">Liste des joueurs</h1>

        <hr>

        @if(count($players) > 0)
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
                                        <th class="text-center">E-mail</th>
                                        <th class="text-center">Sexe</th>
                                        <th class="text-center">Simple</th>
                                        <th class="text-center">Double</th>
                                        <th class="text-center">Mixte</th>
                                        <th class="text-center">Formule</th>
                                        <th class="text-center">Statut CE</th>
                                        <th class="text-center">Statut GBC</th>
                                        <th class="text-center">Corpo</th>
                                        <th class="text-center">Polo</th>
                                        <th class="text-center">Voir</th>
                                        <th class="text-center">Supprimer</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @foreach($players as $player)
                                        <tr>
                                            <td class="text-center">{{ $player->user->forname }}</td>
                                            <td class="text-center">{{ $player->user->name }}</td>
                                            <td class="text-center">{{ $player->user->email }}</td>
                                            <td class="text-center">
                                                @if($player->user->hasGender('man'))
                                                    Homme
                                                @elseif($player->user->hasGender('woman'))
                                                    Femme
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($player->hasSimple(true))
                                                    <span class="fa fa-check-circle-o fa-2x text-success"
                                                          aria-hidden="true"></span>
                                                @elseif($player->hasSimple(false))
                                                    <span class="fa fa-times-circle-o fa-2x text-danger"
                                                          aria-hidden="true"></span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($player->hasDouble(true))
                                                    <span class="fa fa-check-circle-o fa-2x text-success"
                                                          aria-hidden="true"></span>
                                                @elseif($player->hasDouble(false))
                                                    <span class="fa fa-times-circle-o fa-2x text-danger"
                                                          aria-hidden="true"></span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($player->hasMixte(true))
                                                    <span class="fa fa-check-circle-o fa-2x text-success"
                                                          aria-hidden="true"></span>
                                                @elseif($player->hasMixte(false))
                                                    <span class="fa fa-times-circle-o fa-2x text-danger"
                                                          aria-hidden="true"></span>
                                                @endif
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
                                                @if($player->hasCeState('contribution_payable'))
                                                    <i class="text-danger">Contribution à payer</i>
                                                @elseif($player->hasCeState('contribution_paid'))
                                                    <i class="text-success">Contribution payée</i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($player->hasGbcState('non_applicable'))
                                                    <i class="text-center">Non applicable</i>
                                                @elseif($player->hasGbcState('entry_must'))
                                                    <i class="text-danger">Dossier à remettre</i>
                                                @elseif($player->hasGbcState('valid'))
                                                    <i class="text-success">Valide</i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($player->hasCorpoMan(true) || $player->hasCorpoWoman(true) || $player->hasCorpoMixte(true))
                                                    <span class="fa fa-check-circle-o fa-2x text-success"
                                                          aria-hidden="true"></span>
                                                @else
                                                    <span class="fa fa-times-circle-o fa-2x text-danger"
                                                          aria-hidden="true"></span>
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
                                                <a href="{{ route('player.edit', $player->id) }}"
                                                   class="btn btn-info dim">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('player.delete', $player->id) }}"
                                                   class="btn btn-danger dim">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
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
    <script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
    <script type="text/javascript">
        $(".chosen-select").chosen();
    </script>
@stop