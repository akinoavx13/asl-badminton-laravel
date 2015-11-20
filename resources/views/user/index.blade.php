@extends('layout')

@section('title')
    Liste des utilisateurs
@stop

@section('content')

    <h1 class="text-center">Liste des utilisateurs</h1>

    <hr>

    @if(count($users) > 0)
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center">Prénom</th>
                                    <th class="text-center">Nom</th>
                                    <th class="text-center">E-mail</th>
                                    <th class="text-center">Sexe</th>
                                    <th class="text-center">Taille</th>
                                    <th class="text-center">Relation avec lectra</th>
                                    <th class="text-center">Newsletter</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Lien création</th>
                                    <th class="text-center">Voir</th>
                                    <th class="text-center">Supprimer</th>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($users as $user)
                                    <tr>
                                        <td class="text-center">{{ $user->forname }}</td>
                                        <td class="text-center">{{ $user->name }}</td>
                                        <td class="text-center">{{ $user->email }}</td>
                                        <td class="text-center">
                                            @if($user->hasGender('man'))
                                                Homme
                                            @elseif($user->hasGender('woman'))
                                                Femme
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $user->tshirt_size }}</td>
                                        <td class="text-center">
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
                                        </td>
                                        <td class="text-center">
                                            @if($user->hasNewsletter('1'))
                                                <span class="fa fa-check-circle-o text-success"
                                                      aria-hidden="true"></span>
                                            @else
                                                <span class="fa fa-times-circle-o text-danger"
                                                      aria-hidden="true"></span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($user->hasRole('admin'))
                                                <span class="badge badge-danger">
                                            Administrateur
                                        </span>
                                            @elseif($user->hasRole('user'))
                                                <span class="badge badge-primary">
                                            Utilisateur
                                        </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($user->hasFirstConnection('1'))
                                                <div class="text-center">
                                                    <a href="{{ route('user.send_creation_link', $user->id) }}"
                                                       class="btn btn-primary">
                                                        <span class="fa fa-send" aria-hidden="true"></span>
                                                    </a>
                                                </div>
                                            @else
                                                <span class="fa fa-check-circle-o text-success"
                                                      aria-hidden="true"></span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-info dim">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('user.delete', $user->id) }}" class="btn btn-danger dim">
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

        <h2 class="text-center text-danger">Pas d'utilisateur</h2>

    @endif
@stop