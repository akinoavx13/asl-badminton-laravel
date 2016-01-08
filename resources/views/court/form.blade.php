<div class="row">
    <div class="col-md-offset-1 col-md-10">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                @if($court->exists)
                    <h2 class="text-center">Modification du court n° {{ $court }}</h2>
                @else
                    <h2 class="text-center">Création d'un court</h2>
                @endif
            </div>
            <div class="ibox-content">
                @if($court->exists)
                    {!! Form::open(['route' => ['court.update', $court->id], 'class' => 'form-horizontal']) !!}
                @else
                    {!! Form::open(['route' => 'court.store', 'class' => 'form-horizontal']) !!}
                @endif

                <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

                <div class="form-group">
                    <div class="col-md-3">
                        {!! Form::label('number', 'Numéro :', ['class' => 'control-label']) !!}
                        <i class="text-navy">*</i>
                    </div>
                    <div class="col-md-9">
                        {!! Form::text('number', $court->exists ? $court->number : old('number'), ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            {!! Form::label('type', 'Type :', ['class' => 'control-label']) !!}
                            <i class="text-navy">*</i>
                        </div>

                        <div class="col-md-9">
                            <div class="radio-inline">
                                <label>
                                    {!! Form::radio('type', 'simple', $court->exists ? $court->hasType('simple') ? true : false : false, ['required']) !!}
                                    Simple
                                </label>
                            </div>
                            <div class="radio-inline">
                                <label>
                                    {!! Form::radio('type', 'double', $court->exists ? $court->hasType('double') ? true : false : false, ['required']) !!}
                                    Double
                                </label>
                            </div>
                        </div>
                    </div>

                @if($court->exists)
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
    </div>
</div>