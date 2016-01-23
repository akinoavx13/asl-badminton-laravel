<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h1 class="text-center">Bloquer une réservation un jour</h1>
    </div>
    <div class="ibox-content">
        @if($adminReservation->exists)
            {!! Form::open(['route' => ['adminReservation.update'], 'class' =>
            'form-horizontal']) !!}
        @else
            {!! Form::open(['route' => ['adminReservation.store'], 'class' => 'form-horizontal']) !!}
        @endif

        <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('start', 'Début : ', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::text('start', $adminReservation->exists ? $adminReservation->start : old('start'), ['class' => 'form-control', 'data-mask' => '99/99/9999', 'required']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('title', 'Titre : ', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::text('title', $adminReservation->exists ? $adminReservation->title : old('title'), ['class' => 'form-control', 'required']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('comment', 'Commentaire : ', ['class' => 'control-label']) !!}
            </div>
            <div class="col-md-9">
                {!! Form::textarea('comment', $adminReservation->exists ? $adminReservation->comment : old('comment'), ['class' => 'form-control', 'rows' => '3']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('court_id', 'Court :', ['class' => 'control-label', 'required']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                @foreach($courts as $court)
                    <div class="checkbox-inline">
                        <label>
                            {!! Form::checkbox('court_id[]', $court->id, old('court_id')) !!}
                            {{ $court }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('timeSlot_id', 'Crénaux :', ['class' => 'control-label', 'required']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                @foreach($timeSlots as $timeSlot)
                    <div class="checkbox-inline">
                        <label>
                            {!! Form::checkbox('timeSlot_id[]', $timeSlot->id, old('timeSlot_id')) !!}
                            {{ $timeSlot }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('recurring', 'Récurrent :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                <div class="radio-inline">
                    <label>
                        {!! Form::radio('recurring', '1', $adminReservation->exists ? $adminReservation->hasRecurring(true) ? true : false : false, ['required']) !!}
                        Oui
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        {!! Form::radio('recurring', '0', $adminReservation->exists ? $adminReservation->hasRecurring(false) ? true : false : true, ['required']) !!}
                        Non
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group" style="display: none;" id="end">
            <div class="col-md-3">
                {!! Form::label('end', 'Fin : ', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::text('end', $adminReservation->exists ? $adminReservation->end : old('end'), ['class' => 'form-control', 'data-mask' => '99/99/9999']) !!}
            </div>
        </div>

        <div class="form-group" style="display: none;" id="days">
            <div class="col-md-3">
                {!! Form::label('day', 'Jour :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                <div class="checkbox-inline">
                    <label>
                        {!! Form::checkbox('day[]', 'monday', $adminReservation->exists ? $adminReservation->hasDay('monday') ? true : false : false) !!}
                        Lundi
                    </label>
                </div>
                <div class="checkbox-inline">
                    <label>
                        {!! Form::checkbox('day[]', 'tuesday', $adminReservation->exists ? $adminReservation->hasDay('tuesday') ? true : false : false) !!}
                        Mardi
                    </label>
                </div>
                <div class="checkbox-inline">
                    <label>
                        {!! Form::checkbox('day[]', 'wednesday', $adminReservation->exists ? $adminReservation->hasDay('wednesday') ? true : false : false) !!}
                        Mercredi
                    </label>
                </div>
                <div class="checkbox-inline">
                    <label>
                        {!! Form::checkbox('day[]', 'thursday', $adminReservation->exists ? $adminReservation->hasDay('thursday') ? true : false : false) !!}
                        Jeudi
                    </label>
                </div>
                <div class="checkbox-inline">
                    <label>
                        {!! Form::checkbox('day[]', 'friday', $adminReservation->exists ? $adminReservation->hasDay('friday') ? true : false : false) !!}
                        Vendredi
                    </label>
                </div>
            </div>
        </div>

        @if($adminReservation->exists)
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
    <script>

        function showInfo() {
            if ($('input[type=radio][name=recurring]:checked').attr('value') == 1) {
                $('#days').fadeIn(200);
                $('#end').fadeIn(200);
            }
            else {
                $('#days').fadeOut(200);
                $('#end').fadeOut(200);
            }
        }

        $(document).ready(function () {
            $('input[name=recurring]').on('change', showInfo);
            showInfo();
        });
    </script>
@stop