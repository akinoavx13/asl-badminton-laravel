<div class="modal fade actuality" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="fa fa-times"></span>
                </button>
                <h2 class="modal-title text-center">Poster une actualité</h2>
            </div>

            <div class="modal-body">

                {!! Form::open(['route' => 'actuality.store', 'class' => 'form-horizontal', 'files' => 'true']) !!}

                <p class="text-right"><i class="text-navy">* Champs obligatoires</i></p>

                <div class="form-group">
                    <div class="col-md-3">
                        {!! Form::label('title', 'Titre :', ['class' => 'control-label']) !!}
                        <i class="text-navy">*</i>
                    </div>

                    <div class="col-md-9">
                        {!! Form::text('title', old('title'), ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-3">
                        {!! Form::label('content', 'Actualité :', ['class' => 'control-label']) !!}
                    </div>

                    <div class="col-md-9">
                        {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => '3']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-3">
                        {!! Form::label('photo', 'Photo :', ['class' => 'control-label']) !!}
                    </div>

                    <div class="col-md-9">
                        {!! Form::file('photo', ['class' => 'form-control', 'accept' => 'image/*']) !!}
                    </div>
                </div>

            @if($auth->hasRole('admin'))
                <div class="form-group">
                <div class="col-md-3">
                    {!! Form::label('force_mail', 'Force email aux:', ['class' => 'control-label']) !!}
                </div>

                <div class="col-md-9">
                    <div class="radio-inline">
                        <label>
                            {!! Form::radio('force_mail', 'Players', false) !!}
                            Joueurs (actif)
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label>
                            {!! Form::radio('force_mail', 'Users', false) !!}
                            Utilisateurs (actif)
                        </label>
                    </div>
                </div>
                </div>
            @endif

                <div class="form-group text-center">
                    {!! Form::submit('Poster', ['class' => 'btn btn-primary']) !!}
                </div>

                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>