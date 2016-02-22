<div class="ibox float-e-margins">
    <div class="ibox-title">
        @if($timeSlot->exists)
            <h1 class="text-center">Modification du crénau {{ $timeSlot }}</h1>
        @else
            <h1 class="text-center">Création d'un créneau</h1>
        @endif
    </div>
    <div class="ibox-content">
        @if($timeSlot->exists)
            {!! Form::open(['route' => ['timeSlot.update', $timeSlot->id], 'class' => 'form-horizontal']) !!}
        @else
            {!! Form::open(['route' => 'timeSlot.store', 'class' => 'form-horizontal']) !!}
        @endif

        <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('start', 'Heure de début :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                <div class="input-group clockpicker">
                    {!! Form::text('start', $timeSlot->exists ? $timeSlot->start : old('start'), ['class' => 'form-control', 'required']) !!}
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('end', 'Heure de fin :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                <div class="input-group clockpicker">
                    {!! Form::text('end', $timeSlot->exists ? $timeSlot->end : old('end'), ['class' => 'form-control', 'required']) !!}
                    <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
                </div>
            </div>
        </div>

        @if($timeSlot->exists)
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
        $('.clockpicker').clockpicker({
            donetext: 'Valider'
        });
    </script>
@stop