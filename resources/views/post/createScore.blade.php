{!! Form::open(['route' => ['post.storeScorePost', $score->scoreId], 'class' => 'form-horizontal', 'files' =>'true']) !!}
<div class="row" style="margin-top: 5px;">
    <div class="col-md-12">
        {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => '2', 'placeholder' => 'Votre commentaire ...']) !!}
    </div>
</div>

<br>
<div class="row">
    <div class="col-sm-offset-6 col-sm-6 text-right">
        <button type="submit" class="btn btn-primary btn-outline">
            <i class="fa fa-send"></i>
        </button>

        <label title="Upload image file" class="btn btn-primary btn-outline">
            {!! Form::file('photo', ['class' => 'hide', 'accept' => 'image/*']) !!}
            <span class="fa fa-file-image-o"></span>
        </label>
    </div>
</div>
{!! Form::close() !!}