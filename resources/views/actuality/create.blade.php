<div class="row">
    <div class="col-md-offset-4 col-md-4">
        <div class="text-center">
            <button type="button" class="btn btn-primary btn-outline dim" data-toggle="modal"
                    data-target=".actuality">Poster une actualité
            </button>
        </div>
    </div>
</div>

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

                {!! Form::open(['route' => 'actuality.store', 'class' => 'form-horizontal']) !!}

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
                        <i class="text-navy">*</i>
                    </div>

                    <div class="col-md-9">
                        {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => '3', 'required']) !!}
                    </div>
                </div>

                <div class="form-group text-center">
                    {!! Form::submit('Poster', ['class' => 'btn btn-primary']) !!}
                </div>

                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>