@extends('layout')

@section('title')
    Cordage
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">
                @if($rest > 0)
                    Il reste <span class="text-navy">{{ $rest }}</span> cordage{{ $rest > 1 ? 's' : '' }}
                    <hr>
                    <div class="row">
                        <div class="col-md-offset-4 col-md-4">
                            <button type="button" class="btn btn-primary btn-outline dim" data-toggle="modal" data-target=".getRope">
                                    <span class="fa fa-shopping-cart"></span> Envoyer une demande de cordage
                            </button>
                        </div>
                    </div>
                @else
                    <span class="text-danger">
                        Il n'y a plus de cordage
                    </span>
                @endif
            </h1>
        </div>
    </div>


    <h1 class="text-center">Vous avez consommé {{ count($myConsumption) }} cordages</h1>
    <hr>


    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            @if(count($myConsumption) > 0)
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <table class="table table-striped table-hover display" id="myConsumptionList">
                        <thead>
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Tension</th>
                            <th class="text-center">Commentaire</th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach($myConsumption as $oneConsumption)
                                <tr class="text-center">
                                    <td>
                                        {{ $oneConsumption->created_at }}
                                    </td>
                                    <td>
                                        {{ $oneConsumption->tension }} kg
                                    </td>
                                    <td>
                                        {{ $oneConsumption->comment }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
                <h2 class="text-center text-danger">
                    Pas de consommation de cordage
                </h2>
            @endif
        </div>
    </div>


    <div class="modal fade getRope" tabindex="-1" role="dialog" aria-labelledby="getRopeLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="fa fa-times"></span>
                        </button>
                        <h2 class="modal-title text-center">Envoyer une demande de cordage</h2>
                    </div>

                    <div class="modal-body">

                        {!! Form::open(['route' => 'rope.withdrawal', 'class' => 'form-horizontal']) !!}

                        <p class="text-left">Je souhaite envoyer une demande par e-mail à Sport 2000 Cestas, j'irai porter ma raquette dans les meilleurs délais.
                        
                        <div class="form-group">
                            <div class="col-md-3">
                                {!! Form::label('tension', 'Tension du cordage :', ['class' => 'control-label']) !!}
                            </div>

                            <div class="col-md-9">
                                {!! Form::number('tension', $myTension, ['class' => 'form-control', 'step' => '0.1', 'required']) !!}
                            </div>
                        </div>

                        <p>Vous avez la possibilité de laisser un commentaire pour Jérémy de Sport 2000 Cestas (ex: votre date de passage,...).<br> 
                        Ce commentaire est optionnel. </p>
                        <div class="form-group">
                            <div class="col-md-3">
                                {!! Form::label('Commentaire', 'Commentaire :', ['class' => 'control-label']) !!}
                            </div>

                            <div class="col-md-9">
                                {!! Form::text('comment', old('comment'), ['class' => 'form-control']) !!}
                            </div>
                        </div>


                        <div class="form-group text-center">
                            {!! Form::submit("Envoyer", ['class' => 'btn btn-danger']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>

                </div>
            </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myConsumptionList').DataTable( {
                "pageLength": 100,
                "order": [[ 0, "desc" ]],
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