<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h1 class="text-center">Création d'un tournoi</h1>
    </div>
    <div class="ibox-content">
        {!! Form::open(['route' => 'tournament.store', 'class' => 'form-horizontal']) !!}

        <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('start', 'Début :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                {!! Form::text('start', $tournament->exists ? $tournament->start : old('start'), ['class' => 'form-control',
                'data-mask' => '99/99/9999', 'placeholder' => 'dd/mm/yyyy', 'required']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('end', 'Fin :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                {!! Form::text('end', $tournament->exists ? $tournament->end : old('end'), ['class' => 'form-control',
                'data-mask' => '99/99/9999', 'placeholder' => 'dd/mm/yyyy', 'required']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('name', 'Nom :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                {!! Form::text('name', $tournament->exists ? $tournament->name : old('name'), ['class' => 'form-control',
               'required']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('table_number', 'Nombre de tableau :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                {!! Form::number('table_number', $tournament->exists ? $tournament->table_number : old('table_number'), ['class' => 'form-control', 'min' => '1',
               'required']) !!}
            </div>
        </div>

        <div class="form-group text-center">
            {!! Form::submit('Suivant', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>