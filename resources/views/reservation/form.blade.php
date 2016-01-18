<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h1 class="text-center">Réservation du court de {{ $court->type }} n° {{ $court }}</h1>
    </div>
    <div class="ibox-content">
        @if($reservation->exists)
            {!! Form::open(['route' => ['reservation.update', $date, $court->id, $timeSlot_id], 'class' => 'form-horizontal']) !!}
        @else
            {!! Form::open(['route' => ['reservation.store', $date, $court->id, $timeSlot_id], 'class' => 'form-horizontal']) !!}
        @endif

        <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('first_team', 'Première équipe :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::select('first_team', $myTeams, null, ['class' => 'chosen-select', 'style' => 'width: 100%;']) !!}
            </div>
        </div>

        <h1 class="text-center text-danger"><strong>VS</strong></h1>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('second_team', 'Deuxième équipe :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::select('second_team', $teams, null, ['class' => 'chosen-select', 'style' => 'width: 100%;']) !!}
            </div>
        </div>

        @if($reservation->exists)
            <div class="form-group text-center">
                {!! Form::submit('Sauvegarder', ['class' => 'btn btn-primary']) !!}
            </div>
        @else
            <div class="form-group text-center">
                {!! Form::submit('Créer', ['class' => 'btn btn-primary']) !!}
            </div>
        @endif

        {!! Form::close() !!}
    </div>
</div>

@section('javascript')
    <script type="text/javascript">
        $(".chosen-select").chosen();
    </script>
@stop