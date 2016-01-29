<div class="ibox float-e-margins">
    <div class="ibox-title">
        @if($period->exists)
            <h1 class="text-center">Modification du championnat {{ $period }}</h1>
        @else
            <h1 class="text-center">Création d'un championnat</h1>
        @endif
    </div>
    <div class="ibox-content">

        @if($period->exists)
            {!! Form::open(['route' => ['championship.update', $period->id], 'class' => 'form-horizontal']) !!}
        @else
            {!! Form::open(['route' => 'championship.store', 'class' => 'form-horizontal']) !!}
        @endif

        <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('start', 'Début :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                {!! Form::text('start', $period->exists ? $period->start : old('start'), ['class' => 'form-control',
                'data-mask' => '99/99/9999', 'placeholder' => 'dd/mm/yyyy', 'required']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('end', 'Fin :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                {!! Form::text('end', $period->exists ? $period->end : old('end'), ['class' => 'form-control',
                'data-mask' => '99/99/9999', 'placeholder' => 'dd/mm/yyyy', 'required']) !!}
            </div>
        </div>

        @if($period->exists)
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
