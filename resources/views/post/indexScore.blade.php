@foreach($postsScores as $post)
    @if($score->scoreId == $post['scoreId'])
        <div class="row">
            <div class="col-md-1">
                <a href="{{ route('user.show', $post['userId']) }}">
                    <img src="{{ asset($post['userAvatar']) }}" alt="logo" width="35" height="35"/>
                </a>
            </div>
            <div class="col-md-10" style="margin-left: 10px;">
                <a href="{{ route('user.show', $post['userId']) }}"
                   class="font-bold">{{ $post['userName'] }}</a>
                @if($post['userId'] == $auth->id || $auth->hasRole('admin'))
                    <a href="{{ route('post.delete', $post['postId']) }}" class="text-danger"
                       style="float: right;">
                        <span class="fa fa-times"></span>
                    </a>
                @endif
                {!! $post['content'] !!}
                @if($post['photo'])
                    <div class="row">
                        <div class="col-md-12">
                            <div class="img-responsive">
                                <img src="{{ asset($post['photo']) }}"
                                     class="img-rounded" alt="photo"/>
                            </div>
                        </div>
                    </div>
                @endif
                <p style="margin-top: 10px; font-size: 10px;" class="font-bold">
                    {{ $post['createdAt'] }}
                </p>
            </div>
        </div>
    @endif
@endforeach