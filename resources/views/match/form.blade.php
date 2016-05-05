<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h1 class="text-center">Modification d'un match</h1>
    </div>
    <div class="ibox-content">

        {!! Form::open(['route' => ['match.update', $match->id], 'class' => 'form-horizontal']) !!}

        <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('matches_number_in_table', 'N° de match :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::number('matches_number_in_table', $match->exists ? $match->matches_number_in_table : old('matches_number_in_table'), ['class' => 'form-control', 'required']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('first_team_id', 'Première équipe :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::select('first_team_id', $teams['firstTeam'], null, ['class' => 'chosen-select', 'style' => 'width: 100%;']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('second_team_id', 'Deuxième équipe :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::select('second_team_id', $teams['secondTeam'], null, ['class' => 'chosen-select', 'style' => 'width: 100%;']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('next_match_winner_id', 'N° du match vainqueur :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::select('next_match_winner_id', $nextMatchWinner, null, ['class' => 'chosen-select', 'style' => 'width: 100%;']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('next_match_looser_id', 'N° du match perdant :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::select('next_match_looser_id', $nextMatchLooser, null, ['class' => 'chosen-select', 'style' => 'width: 100%;']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('display', 'Afficher :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                <div class="radio-inline">
                    <label>
                        {!! Form::radio('display', '1', $match->exists ? $match->hasDisplay(true) ? true : false : false, ['required']) !!}
                        Oui
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        {!! Form::radio('display', '0', $match->exists ? $match->hasDisplay(false) ? true : false : true, ['required']) !!}
                        Non
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            {!! Form::submit('Sauvegarder', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

        <div class="form-group text-center">
            <a href="{{ route('match.nextStep', $match->id) }}" class="btn btn-warning">Passer à la prochaine étape</a>
        </div>

    </div>
</div>


@section('javascript')
    <script type="text/javascript">
        $(".chosen-select").chosen();
    </script>
@stop