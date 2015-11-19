@extends('layout')

@section('title')
    Modification de {{ $user }}
@stop

@section('content')
    <div class="row">
        <div class="col-md-push-3 col-md-6">
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
                                <label>Email: </label>
                            </div>
                            <div class="col-md-8">
                                {{ $user->email }}
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Anniversaire:</label>
                            </div>
                            <div class="col-md-8">
                                {{ \Jenssegers\Date\Date::create($user->getBirthday()->year, $user->getBirthday()->month, $user->getBirthday()->day)->format('l j F Y') }}
                                <i>({{ \Jenssegers\Date\Date::create($user->getBirthday()->year, $user->getBirthday()->month, $user->getBirthday()->day)->age }} ans)</i>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Sexe:</label>
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
                                <label>Lectra:</label>
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
                                <label>Etat:</label>
                            </div>
                            <div class="col-md-8">
                                @if($user->hasState('holiday'))
                                    En vacances jusqu'au <i class="text-warning">{{
                             \Jenssegers\Date\Date::create($user->getEndingHoliday()->year, $user->getEndingHoliday()->month, $user->getEndingHoliday()->day)->format('l j F Y') }}</i>
                                @elseif($user->hasState('hurt'))
                                    Bléssé jusqu'au <i class="text-warning">{{
                            \Jenssegers\Date\Date::create($user->getEndingInjury()->year, $user->getEndingInjury()->month, $user->getEndingInjury()->day)->format('l j F Y') }}</i>
                                @elseif($user->hasState('active'))
                                    Actif
                                @elseif($user->hasState('inactive'))
                                    Inactif
                                @endif
                            </div>
                        </div>
                    </li>

                    @if($auth->hasRole('admin') || $auth->hasOwner($user->id))
                        <li>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Adresse:</label>
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
                                    <label>Contact:</label>
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

                        <li>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Licence:</label>
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
                                    <label>Taille de t-shirt:</label>
                                </div>
                                <div class="col-md-8">
                                    {{ $user->tshirt_size }}
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Actif:</label>
                                </div>
                                <div class="col-md-8">
                                    @if($user->hasActive('1'))
                                        <span class="fa fa-check-circle-o text-success" aria-hidden="true"></span>
                                    @elseif($user->hasActive('0'))
                                        <span class="fa fa-times-circle-o text-danger"aria-hidden="true"></span>
                                    @endif
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Newsletter:</label>
                                </div>
                                <div class="col-md-8">
                                    @if($user->hasNewsletter('1'))
                                        <span class="fa fa-check-circle-o text-success" aria-hidden="true"></span>
                                    @elseif($user->hasNewsletter('0'))
                                        <span class="fa fa-times-circle-o text-danger"aria-hidden="true"></span>
                                    @endif
                                </div>
                            </div>
                        </li>
                    </ul>

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
    </div>
@stop