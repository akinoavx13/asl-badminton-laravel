<div class="ibox float-e-margins">
    <div class="ibox-title">
        @if($season->exists)
            <h1 class="text-center">Modification de {{ $season }}</h1>
        @else
            <h1 class="text-center">Création d'une saison</h1>
        @endif
    </div>
    <div class="ibox-content">

        @if($season->exists)
            {!! Form::open(['route' => ['season.update', $season->id], 'class' => 'form-horizontal']) !!}
            <input name="season_id" type="hidden" value="{{ $season->id }}">
        @else
            {!! Form::open(['route' => 'season.store', 'class' => 'form-horizontal']) !!}
        @endif

        <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('name', 'Nom :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::text('name', $season->exists ? $season->name : old('name'), ['class' => 'form-control', 'required']) !!}
            </div>
        </div>

        @if($season->exists)
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
