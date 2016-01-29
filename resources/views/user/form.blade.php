<div class="ibox float-e-margins">
    <div class="ibox-title">
        @if($user->exists)
            <h1 class="text-center">Modification de {{ $user }}</h1>
        @else
            <h1 class="text-center">Création d'un utilisateur</h1>
        @endif
    </div>
    <div class="ibox-content">

        @if($user->exists)
            {!! Form::open(['route' => ['user.update', $user->id], 'class' => 'form-horizontal', 'files' => true]) !!}

            <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('forname', 'Prénom :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>
                <div class="col-md-9">
                    {!! Form::text('forname', $user->exists ? $user->forname : old('forname'), ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('name', 'Nom :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>
                <div class="col-md-9">
                    {!! Form::text('name', $user->exists ? $user->name : old('name'), ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('email', 'Email :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>
                <div class="col-md-9">
                    {!! Form::email('email', $user->exists ? $user->email : old('email'), ['class' => 'form-control', 'required', 'disabled']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('password', 'Mot de passe :', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('password_confirmation', 'Confirmer :', ['class' => 'control-label']) !!}
                </div>
                <div class="col-md-9">
                    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('birthday', 'Date de naissance :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>

                <div class="col-md-9">
                    {!! Form::text('birthday', $user->exists ? $user->birthday : old('birthday'), ['class' => 'form-control', 'data-mask' => '99/99/9999', 'placeholder' => 'dd/mm/yyyy', 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('tshirt_size', 'Taille de t-shirt :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>

                <div class="col-md-9">
                    {!! Form::select('tshirt_size', ['XXS' => 'XXS','XS' => 'XS','S' => 'S','M'=>'M','L' => 'L','XL' =>'XL','XXL' => 'XXL'],
                    $user->exists ? $user->tshirt_size : old('tshirt_size'),['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('gender', 'Sexe :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>

                <div class="col-md-9">
                    <div class="radio-inline">
                        <label>
                            {!! Form::radio('gender', 'man', $user->exists ? $user->hasGender('man') ? true : false : false, ['required']) !!}
                            Homme
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label>
                            {!! Form::radio('gender', 'woman', $user->exists ? $user->hasGender('woman') ? true :
                            false : true, ['required']) !!}
                            Femme
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('avatar', 'Photo :', ['class' => 'control-label']) !!}
                </div>

                <div class="col-md-9">
                    {!! Form::file('avatar', ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('address', 'Adresse :', ['class' => 'control-label']) !!}
                </div>

                <div class="col-md-9">
                    {!! Form::textarea('address', $user->exists ? $user->address : old('address'), ['class' => 'form-control', 'rows' => '3']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('phone', 'Téléphone :', ['class' => 'control-label']) !!}
                </div>

                <div class="col-md-9">
                    {!! Form::text('phone', $user->exists ? $user->phone : old('phone'), ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('license', 'Licence :', ['class' => 'control-label']) !!}
                </div>

                <div class="col-md-9">
                    {!! Form::text('license', $user->exists ? $user->license : old('license'), ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('state', 'Etat :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>

                <div class="col-md-9">
                    {!! Form::select('state', ['holiday' => 'En vacances', 'hurt' => 'Blessé', 'active' => 'Actif', 'inactive' => 'Inactif'],
                    $user->exists ? $user->state : old('state'),['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group" id="endingInjury">
                <div class="col-md-3">
                    {!! Form::label('ending_injury', 'Fin de blessure :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>

                <div class="col-md-9">
                    {!! Form::text('ending_injury', $user->exists ? $user->ending_injury : old('ending_injury'), ['class' => 'form-control', 'data-mask' => '99/99/9999', 'placeholder' => 'dd/mm/yyyy']) !!}
                </div>
            </div>

            <div class="form-group" id="endingHolidays">
                <div class="col-md-3">
                    {!! Form::label('ending_holiday', 'Fin de vacances :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>

                <div class="col-md-9">
                    {!! Form::text('ending_holiday', $user->exists ? $user->ending_holiday : old('ending_holiday'), ['class' => 'form-control', 'data-mask' => '99/99/9999', 'placeholder' => 'dd/mm/yyyy']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('lectra_relationship', 'Relation avec lectra :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>

                <div class="col-md-9">
                    {!! Form::select('lectra_relationship', ['lectra' => 'Lectra', 'child' => 'Enfant', 'conjoint' =>
                    'Conjoint', 'external' => 'Externe', 'trainee' => 'Stagiaire', 'subcontractor' => 'Prestataire'],
                    $user->exists ? $user->lectra_relationship : old('lectra_relationship'),['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('newsletter', "S'inscrire à la newsletter", ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>


                <div class="col-md-9">
                    <div class="radio-inline">
                        <label>
                            {!! Form::radio('newsletter', '1', $user->exists ? $user->hasNewsletter(true) ? true : false : false, ['required']) !!}
                            Oui
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label>
                            {!! Form::radio('newsletter', '0', $user->exists ? $user->hasNewsletter(false) ? true : false : false, ['required']) !!}
                            Non
                        </label>
                    </div>
                </div>
            </div>

            @if($auth->hasRole('admin'))
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h2 class="text-center">Réservé aux administrateur</h2>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <div class="col-md-3">
                                {!! Form::label('role', 'Role :', ['class' => 'control-label']) !!}
                                <i class="text-navy">*</i>
                            </div>

                            <div class="col-md-9">
                                {!! Form::select('role', ['admin' => 'Administrateur', 'user' => 'Utilisateur', 'ce' => 'CE'],
                                $user->exists ? $user->role : old('role'), ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3">
                                {!! Form::label('active', 'Actif :', ['class' => 'control-label']) !!}
                                <i class="text-navy">*</i>
                            </div>

                            <div class="col-md-9">
                                <div class="radio-inline">
                                    <label>
                                        {!! Form::radio('active', '1', $user->exists ? $user->hasActive(true) ? true : false : false, ['required']) !!}
                                        Oui
                                    </label>
                                </div>
                                <div class="radio-inline">
                                    <label>
                                        {!! Form::radio('active', '0', $user->exists ? $user->hasActive(false) ? true : false : false, ['required']) !!}
                                        Non
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endif

            <div class="form-group text-center">
                {!! Form::submit('Sauvegarder', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
        @elseif(! $user->exists && $auth->hasRole('admin'))

            {!! Form::open(['route' => ['user.store'], 'class' => 'form-horizontal']) !!}
            {!! Form::token() !!}

            <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('forname', 'Prénom :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>
                <div class="col-md-9">
                    {!! Form::text('forname', old('forname'), ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('name', 'Nom :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>
                <div class="col-md-9">
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('email', 'Email :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>
                <div class="col-md-9">
                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('role', 'Role :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>

                <div class="col-md-9">
                    {!! Form::select('role', ['user' => 'Utilisateur', 'admin' => 'Administrateur', 'ce' => 'CE'], old('role'), ['class' => 'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('active', 'Actif :', ['class' => 'control-label']) !!}
                    <i class="text-navy">*</i>
                </div>

                <div class="col-md-9">
                    <div class="radio-inline">
                        <label>
                            {!! Form::radio('active', '1', false, ['required']) !!}
                            Oui
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label>
                            {!! Form::radio('active', '0', false, ['required']) !!}
                            Non
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                {!! Form::submit('Créer', ['class' => 'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}
        @endif
    </div>
</div>

@section('javascript')
<script>

    function updateSelect() {

        var state = $('select[name=state]').val();

        if (state == 'hurt') {
            $('#endingInjury').show();
            $('#endingHolidays').hide();
        }
        else if (state == 'holiday') {
            $('#endingHolidays').show();
            $('#endingInjury').hide();
        }
        else {
            $('#endingInjury').hide();
            $('#endingHolidays').hide();
        }
    }

    $(document).ready(function () {
        $('select[name=state]').on('change', updateSelect);
        updateSelect();
    });
</script>

@stop