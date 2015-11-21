<div class="row">

    <div class="col-md-push-1 col-md-10">

        <div class="ibox float-e-margins">
            <div class="ibox-title">
            </div>
            <div class="ibox-content">

                {!! Form::open(['route' => ['setting.update', $setting->id], 'class' => 'form-horizontal']) !!}
                {!! Form::token() !!}

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

                <div class="form-group text-center">
                    {!! Form::submit('Sauvegarder', ['class' => 'btn btn-primary']) !!}
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>