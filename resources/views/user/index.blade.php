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
                            <table class="table table-striped table-hover display" id="userList">
                                <thead>
                                <tr>
                                    <th class="text-center">Prénom</th>
                                    <th class="text-center">Nom</th>
                                    <th class="text-center">E-mail</th>
                                    <th class="text-center">Sexe</th>
                                    <th class="text-center">Taille</th>
                                    <th class="text-center">Tension</th>
                                    <th class="text-center">Relation avec lectra</th>
                                    <th class="text-center">Etat</th>
                                    <th class="text-center">Email Actu</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Lien création</th>
                                    <th class="text-center">Voir</th>
                                    <th class="text-center">Supprimer</th>
                                    <th class="text-center">Derniere Saison</th>
                                    <th class="text-center">Saison Précédente</th>
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
                                        <td class="text-center">{{ $user->tension }}</td>
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
                                            @elseif($user->hasLectraRelation('partnership'))
                                                Mairie
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($user->hasState('active'))
                                                <i class="text-navy">Actif</i>
                                            @elseif($user->hasState('inactive'))
                                                <i class="text-warning">Inactif</i>
                                            @elseif($user->hasState('holiday'))
                                                <i class="text-warning">En vacances
                                                    jusqu'au {{ $user->ending_holiday }}</i>
                                            @elseif($user->hasState('hurt'))
                                                <i class="text-danger">Blessé
                                                    jusqu'au {{ $user->ending_injury }}</i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($user->hasNewsletter(true))
                                                <span class="fa fa-check-circle-o fa-2x text-success"
                                                      aria-hidden="true"><span hidden>newsletter</span></span>
                                            @elseif($user->hasNewsletter(false))
                                                <span class="fa fa-times-circle-o fa-2x text-danger"
                                                      aria-hidden="true"><span hidden>pas newsletter</span></span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($user->hasRole('admin'))
                                                <span class="badge badge-danger">Administrateur</span>
                                            @elseif($user->hasRole('user'))
                                                <span class="badge badge-primary">Utilisateur</span>
                                            @elseif($user->hasRole('ce'))
                                                <span class="badge badge-warning">CE</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($user->hasFirstConnection(true))
                                                <div class="text-center">
                                                    <a href="{{ route('user.send_creation_link', $user->id) }}"
                                                       class="btn btn-primary">
                                                        <span class="fa fa-send" aria-hidden="true"><span hidden>première connection</span></span>
                                                    </a>
                                                </div>
                                            @elseif($user->hasFirstConnection(false))
                                                <span class="fa fa-check-circle-o fa-2x text-success"
                                                      aria-hidden="true"><span hidden>pas première connection</span></span>
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
                                        <td>
                                                @if (array_key_exists($user->id,$usersInLastSeason))
                                                    <span class="fa fa-check-circle-o fa-2x text-success"
                                                          aria-hidden="true"><span hidden>Derniere Saison</span></span>
                                                @else
                                                    <span class="fa fa-times-circle-o fa-2x text-danger"
                                                      aria-hidden="true"><span hidden>Pas derniere Saison</span></span>
                                                @endif
                                        </td>
                                        <td>
                                                @if (array_key_exists($user->id,$usersInPreviousSeason))
                                                    <span class="fa fa-check-circle-o fa-2x text-success"
                                                          aria-hidden="true"><span hidden>Precedente Saison</span></span>
                                                @else
                                                    <span class="fa fa-times-circle-o fa-2x text-danger"
                                                      aria-hidden="true"><span hidden>Pas precedente Saison</span></span>
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
    @else

        <h2 class="text-center text-danger">Pas d'utilisateur</h2>

    @endif
@stop

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#userList').DataTable( {
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