{!! Form::open(['route' => ['post.storeActualityPost', $actuality['actualityId']], 'class' => 'form-horizontal']) !!}
<div class="row" style="margin-top: 5px;">
    <div class="col-md-10">
        {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => '2', 'placeholder' => 'Votre commentaire ...']) !!}
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary btn-outline">
            <i class="fa fa-send"></i>
        </button>
    </div>
</div>
{!! Form::close() !!}