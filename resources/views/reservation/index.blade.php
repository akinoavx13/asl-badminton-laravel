@extends('layout')

@section('title')
    Réservations
@stop

@section('content')

    <h1 class="text-center">
        Réserver un court
    </h1>



    <div class="row">
        <div class="col-md-offset-1 col-md-10">

            @if(count($timeSlots) > 0 || count($courts) > 0)
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <table class="table table-striped table-hover display" id="daysList">
                        <thead>
                        <tr>
                            <th rowspan="{{ count($timeSlots) }}" class="text-center">Jour</th>
                            <th class="text-center">Crénaux</th>
                            @foreach($courts as $court)
                                <th class="text-center">{{ ucfirst($court->type) }} {{ $court }}</th>
                            @endforeach
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($allDays as $day)
                            <tr class="text-center">
                                <td rowspan="{{ count($timeSlots) }}">
                                    {{ ucfirst($day->format('l j F Y')) }}
                                </td>
                                <td>
                                    {{ $timeSlots[0] }}
                                </td>
                                @foreach($courts as $court)
                                    <td>
                                        @if(\Carbon\Carbon::today() > $day)
                                            <span class="fa fa-clock-o"></span>
                                        @else
                                            <a href="">Réserver</a>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            @if(count($timeSlots) > 1)
                                @foreach($timeSlots as $timeSlot)
                                    @if($timeSlot != $timeSlots[0])
                                        <tr class="text-center">
                                            <td>{{ $timeSlot }}</td>
                                            @foreach($courts as $court)
                                                <td>
                                                    @if(\Carbon\Carbon::today() > $day)
                                                        <span class="fa fa-clock-o"></span>
                                                    @else
                                                        <a href="">Réserver</a>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
                <h1 class="text-danger text-center">
                    Pas de réservation disponible pour le moment
                </h1>
            @endif
        </div>
    </div>

@stop

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#daysList').DataTable( {
                paging: false,
                ordering:  false,
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