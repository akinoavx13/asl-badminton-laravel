@extends('layout')

@section('title')
    Modification de {{ $user }}
@stop

@section('content')
    <div class="row">
        <div class={!! $player === null ? "\"col-md-push-3 " : "\""!!}col-md-6">

            <div class="widget navy-bg p-xl">
                <p class="text-center">
                    @if($user->avatar)
                        <img src="{{ url($user->avatar) }}"
                             class="img-circle" alt="logo" width="200" height="200"/>
                    @else
                        <img src="{{ asset('img/anonymous.png') }}"
                             class="img-circle" alt="logo" width="200" height="200"/>
                    @endif
                </p>
                <br>

                <h2 class="text-center">{{ $user }}</h2>

                <ul class="list-unstyled m-t-md">

                    <li>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Email:</label>
                            </div>
                            <div class="col-md-8">
                                {{ $user->email }}
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Sexe :</label>
                            </div>
                            <div class="col-md-8">
                                @if($user->hasGender('man'))
                                    Homme
                                @elseif($user->hasGender('woman'))
                                    Femme
                                @endif
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Lectra :</label>
                            </div>
                            <div class="col-md-8">
                                @if($user->hasLectraRelation('lectra'))
                                    Lectra
                                @elseif($user->hasLectraRelation('child'))
                                    Enfant
                                @elseif($user->hasLectraRelation('conjoint'))
                                    Conjoint
                                @elseif($user->hasLectraRelation('external'))
                                    Externe
                                @elseif($user->hasLectraRelation('trainee'))
                                    Stagiaire
                                @elseif($user->hasLectraRelation('subcontractor'))
                                    Prestataire
                                @endif
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Etat :</label>
                            </div>
                            <div class="col-md-8">
                                @if($user->hasState('holiday'))
                                    En vacances jusqu'au <i class="text-warning">{{
                             \Jenssegers\Date\Date::create($user->getEndingHoliday()->year, $user->getEndingHoliday()->month, $user->getEndingHoliday()->day)->format('l j F') }}</i>
                                @elseif($user->hasState('hurt'))
                                    Bléssé jusqu'au <i class="text-warning">{{
                            \Jenssegers\Date\Date::create($user->getEndingInjury()->year, $user->getEndingInjury()->month, $user->getEndingInjury()->day)->format('l j F') }}</i>
                                @elseif($user->hasState('active'))
                                    Actif
                                @elseif($user->hasState('inactive'))
                                    Inactif
                                @endif
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Téléphone :</label>
                            </div>
                            <div class="col-md-8">
                                @if($user->phone !== null)
                                    {{ $user->phone }}
                                @else
                                    <i class="text-warning">Non renseigné</i>
                                @endif
                            </div>
                        </div>
                    </li>

                    @if($auth->hasRole('admin') || $auth->hasOwner($user->id))
                        <li>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Anniversaire :</label>
                                </div>
                                <div class="col-md-8">
                                    {{ \Jenssegers\Date\Date::create($user->getBirthday()->year, $user->getBirthday()->month, $user->getBirthday()->day)->format('l j F') }}
                                    <i>({{ \Jenssegers\Date\Date::create($user->getBirthday()->year, $user->getBirthday()->month, $user->getBirthday()->day)->age }}
                                        ans)</i>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Adresse :</label>
                                </div>
                                <div class="col-md-8">
                                    @if($user->address !== null)
                                        {{ $user->address }}
                                    @else
                                        <i class="text-warning">Non renseignée</i>
                                    @endif
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Licence :</label>
                                </div>
                                <div class="col-md-8">
                                    @if($user->license !== null)
                                        {{ $user->license }}
                                    @else
                                        <i class="text-warning">Non renseignée</i>
                                    @endif
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Taille de t-shirt :</label>
                                </div>
                                <div class="col-md-8">
                                    {{ $user->tshirt_size }}
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Actif :</label>
                                </div>
                                <div class="col-md-8">
                                    @if($user->hasActive(true))
                                        <span class="fa fa-check-circle-o fa-2x text-success" aria-hidden="true"></span>
                                    @elseif($user->hasActive(false))
                                        <span class="fa fa-times-circle-o fa-2x text-warning" aria-hidden="true"></span>
                                    @endif
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Newsletter :</label>
                                </div>
                                <div class="col-md-8">
                                    @if($user->hasNewsletter(true))
                                        <span class="fa fa-check-circle-o fa-2x text-success" aria-hidden="true"></span>
                                    @elseif($user->hasNewsletter(false))
                                        <span class="fa fa-times-circle-o fa-2x text-warning" aria-hidden="true"></span>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>

                @if($auth->hasRole('admin') || $auth->hasOwner($user->id))
                    <div class="text-center">
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-info">Modifier</a>
                    </div>
                @else
                    <br>
                    <div class="text-center">
                        <a href="mailto:{{ $user->email }}" class="btn btn-info">Envoyer un mail</a>
                    </div>
                @endif
            </div>
        </div>

        @if($player !== null)
            <div class="col-md-6">
                <div class="widget blue-bg p-xl">
                    <h2 class="text-center">Inscrit en {{ $player->season }}</h2>

                    <ul class="list-unstyled m-t-md">
                        <li>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Formule :</label>
                                </div>
                                <div class="col-md-8">
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
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Simple :</label>
                                </div>
                                <div class="col-md-8">
                                    @if($player->hasSimple(true))
                                        <span class="fa fa-check-circle-o fa-2x text-navy"
                                              aria-hidden="true"></span>
                                    @else
                                        <span class="fa fa-times-circle-o fa-2x text-warning"
                                              aria-hidden="true"></span>
                                    @endif
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Double :</label>
                                </div>
                                <div class="col-md-8">
                                    @if($player->hasDouble(true))
                                        <span class="fa fa-check-circle-o fa-2x text-navy"
                                              aria-hidden="true"></span>
                                    @else
                                        <span class="fa fa-times-circle-o fa-2x text-warning"
                                              aria-hidden="true"></span>
                                    @endif
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Mixte :</label>
                                </div>
                                <div class="col-md-8">
                                    @if($player->hasMixte(true))
                                        <span class="fa fa-check-circle-o fa-2x text-navy"
                                              aria-hidden="true"></span>
                                    @else
                                        <span class="fa fa-times-circle-o fa-2x text-warning"
                                              aria-hidden="true"></span>
                                    @endif
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>T-shirt :</label>
                                </div>
                                <div class="col-md-8">
                                    @if($player->hasTShirt(true))
                                        <span class="fa fa-check-circle-o fa-2x text-navy"
                                              aria-hidden="true"></span>
                                    @else
                                        <span class="fa fa-times-circle-o fa-2x text-warning"
                                              aria-hidden="true"></span>
                                    @endif
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Corpo :</label>
                                </div>
                                <div class="col-md-8">
                                    @if($player->hasCorpoMan(true))
                                        Homme
                                        <br>
                                    @endif
                                    @if($player->hasCorpoWoman(true))
                                        Femme
                                        <br>
                                    @endif
                                    @if($player->hasCorpoMixte(true))
                                        Mixte
                                        <br>
                                    @endif
                                    @if($player->hasCorpoMan(false) && $player->hasCorpoWoman(false) && $player->hasCorpoMixte(false))
                                        <span class="fa fa-times-circle-o fa-2x text-warning"
                                              aria-hidden="true"></span>
                                    @endif
                                </div>
                            </div>
                        </li>
                        @if($auth->hasRole('admin') || $auth->hasOwner($user->id))
                            <li>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Statue CE :</label>
                                    </div>
                                    <div class="col-md-8">
                                        @if($player->hasCeState('contribution_payable'))
                                            <i class="text-warning">Contribution à payer</i>
                                        @elseif($player->hasCeState('contribution_paid'))
                                            <i class="text-navy">Contribution payée</i>
                                        @endif
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Statue GBC :</label>
                                    </div>
                                    <div class="col-md-8">
                                        @if($player->hasGbcState('non_applicable'))
                                            <i class="text-warning">Non applicable</i>
                                        @elseif($player->hasGbcState('entry_must'))
                                            <i class="text-warning">Dossier à remettre</i>
                                        @elseif($player->hasGbcState('valid'))
                                            <i class="text-navy">Valide</i>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endif
                    </ul>
                    @if($auth->hasRole('admin') || $auth->hasOwner($user->id))
                        <div class="text-center">
                            <a href="{{ route('player.edit', $player->id) }}" class="btn btn-info">Modifier</a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@stop