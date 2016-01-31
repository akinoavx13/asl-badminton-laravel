<div class="ibox float-e-margins">
    <div class="ibox-title">
    </div>
    <div class="ibox-content">

        {!! Form::open(['route' => ['setting.update', $setting->id], 'class' => 'form-horizontal']) !!}

        <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('cestas_sport_email', 'Email cestas sport :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::email('cestas_sport_email', $setting->exists ? $setting->cestas_sport_email : old('cestas_sport_email'), ['class' => 'form-control', 'required']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('web_site_email', 'Email du site :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::email('web_site_email', $setting->exists ? $setting->web_site_email : old('web_site_email'), ['class' => 'form-control', 'required']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('web_site_name', 'Expéditeur email site :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::text('web_site_name', $setting->exists ? $setting->web_site_name : old('web_site_name'), ['class' => 'form-control', 'required']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('cc_email', 'Email du CC :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::email('cc_email', $setting->exists ? $setting->cc_email : old('cc_email'), ['class' => 'form-control', 'required']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('can_buy_t_shirt', 'Achat de t-shirt :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                <div class="radio-inline">
                    <label>
                        {!! Form::radio('can_buy_t_shirt', '1', $setting->exists ? $setting->hasBuyTShirt(true) ? true : false : false, ['required']) !!}
                        Oui
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        {!! Form::radio('can_buy_t_shirt', '0', $setting->exists ? $setting->hasBuyTShirt(false) ? true : false : true, ['required']) !!}
                        Non
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('can_enroll', 'Inscription  :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                <div class="radio-inline">
                    <label>
                        {!! Form::radio('can_enroll', '1', $setting->exists ? $setting->hasEnroll(true) ? true : false : false, ['required']) !!}
                        Oui
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        {!! Form::radio('can_enroll', '0', $setting->exists ? $setting->hasEnroll(false) ? true : false : true, ['required']) !!}
                        Non
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('leisure_price', 'Prix loisir :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::number('leisure_price', $setting->exists ? $setting->leisure_price : old('leisure_price'), ['class' => 'form-control', 'required', 'min' => 0]) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('leisure_external_price', 'Prix loisir externe :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::number('leisure_external_price', $setting->exists ? $setting->leisure_external_price : old('leisure_external_price'), ['class' => 'form-control', 'required', 'min' => 0]) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('fun_price', 'Prix fun :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::number('fun_price', $setting->exists ? $setting->fun_price : old('fun_price'), ['class' => 'form-control', 'required', 'min' => 0]) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('fun_external_price', 'Prix fun externe :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::number('fun_external_price', $setting->exists ? $setting->fun_external_price : old('fun_external_price'), ['class' => 'form-control', 'required', 'min' => 0]) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('performance_price', 'Prix performance :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::number('performance_price', $setting->exists ? $setting->performance_price : old('performance_price'), ['class' => 'form-control', 'required', 'min' => 0]) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('performance_external_price', 'Prix performance externe :') !!}<i
                        class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::number('performance_external_price', $setting->exists ? $setting->performance_external_price : old('performance_external_price'), ['class' => 'form-control', 'required', 'min' => 0]) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('corpo_price', 'Prix corpo :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::number('corpo_price', $setting->exists ? $setting->corpo_price : old('corpo_price'), ['class' => 'form-control', 'required', 'min' => 0]) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('corpo_external_price', 'Prix corpo externe :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::number('corpo_external_price', $setting->exists ? $setting->corpo_external_price : old('corpo_external_price'), ['class' => 'form-control', 'required', 'min' => 0]) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('competition_price', 'Prix compétition :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::number('competition_price', $setting->exists ? $setting->competition_price : old('competition_price'), ['class' => 'form-control', 'required', 'min' => 0]) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('competition_external_price', 'Prix compétition externe :') !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::number('competition_external_price', $setting->exists ? $setting->competition_external_price : old('competition_external_price'), ['class' => 'form-control', 'required', 'min' => 0]) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('t_shirt_price', 'Prix t-shirt :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>
            <div class="col-md-9">
                {!! Form::number('t_shirt_price', $setting->exists ? $setting->t_shirt_price : old('t_shirt_price'), ['class' => 'form-control', 'required', 'min' => 0]) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('championship_simple_woman', 'Championnat simple femme :', ['class' => 'control-label']) !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                <div class="radio-inline">
                    <label>
                        {!! Form::radio('championship_simple_woman', '1', $setting->exists ? $setting->hasChampionshipSimpleWoman(true) ?
                        true :
                        false :
                        false, ['required']) !!}
                        Oui
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        {!! Form::radio('championship_simple_woman', '0', $setting->exists ? $setting->hasChampionshipSimpleWoman
                        (false)
                        ? true : false : true, ['required']) !!}
                        Non
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                {!! Form::label('championship_double_woman', 'Championnat double femme :', ['class' => 'control-label'])
                 !!}
                <i class="text-navy">*</i>
            </div>

            <div class="col-md-9">
                <div class="radio-inline">
                    <label>
                        {!! Form::radio('championship_double_woman', '1', $setting->exists ? $setting->hasChampionshipDoubleWoman(true) ?
                        true :
                        false :
                        false, ['required']) !!}
                        Oui
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        {!! Form::radio('championship_double_woman', '0', $setting->exists ?
                        $setting->hasChampionshipDoubleWoman
                        (false)
                        ? true : false : true, ['required']) !!}
                        Non
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            {!! Form::submit('Sauvegarder', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>