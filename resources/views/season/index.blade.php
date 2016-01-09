@extends('layout')

@section('title')
    Liste des saisons
@stop

@section('content')

    <h1 class="text-center">Liste des saisons</h1>

    <hr>

    @if(count($seasons) > 0)

        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <table class="table table-striped table-hover display" id="seasonList">
                            <thead>
                            <tr>
                                <th class="text-center">Nom</th>
                                <th class="text-center">Actif</th>
                                <th class="text-center">Editer</th>
                                <th class="text-center">Supprimer</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($seasons as $season)
                                <tr>
                                    <td class="text-center">
                                        {{ $season->name }}
                                    </td>
                                    <td class="text-center">
                                        @if($season->hasActive(true))
                                            <span class="fa fa-check-circle-o fa-2x text-success"
                                                  aria-hidden="true"></span>
                                        @elseif($season->hasActive(false))
                                            <a href="{{ route('season.change_active_attribute', $season->id) }}"
                                               class="btn btn-primary">Devenir active</a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('season.edit', $season->id) }}" class="btn btn-info dim">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('season.delete', $season->id) }}" class="btn btn-danger dim">
                                            <i class="fa fa-trash"></i>
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
    @else

        <h2 class="text-center text-danger">Pas de saison</h2>

    @endif
@stop

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#seasonList').DataTable( {
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