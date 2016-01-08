@extends('layout')

@section('title')
    Paramètre créneaux
@stop

@section('content')

    <h1 class="text-center">Paramètre créneaux</h1>
    <hr>

    <div class="row">
        <div class="col-md-offset-5 col-md-2">
            <a href="{{ route('timeSlot.create') }}" class="btn btn-primary btn-block">Ajouter un créneau <span
                        class="fa fa-plus"></span></a>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12">
            @if(count($timeSlots) > 0)
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover display" id="timeSlotsList">
                            <thead>
                            <tr>
                                <th class="text-center">Heure début</th>
                                <th class="text-center">Heure fin</th>
                                <th class="text-center">Editer</th>
                                <th class="text-center">Supprimer</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($timeSlots as $timeSlot)
                                    <tr class="text-center">
                                        <td>
                                            {{ $timeSlot->start }}
                                        </td>
                                        <td>
                                            {{ $timeSlot->end }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('timeSlot.edit', $timeSlot->id) }}" class="btn btn-info dim">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('timeSlot.delete', $timeSlot->id) }}" class="btn btn-danger dim">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                        @else
                        <h2 class="text-center text-danger">
                            Pas de créneau
                        </h2>
                </div>
            </div>
            @endif
        </div>
    </div>

@stop

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#timeSlotsList').DataTable( {
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