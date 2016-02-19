@if(count($actualities) > 0)

    @foreach($actualities as $actuality)
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h2 class="text-center">
                    {{ $actuality['title'] }}
                </h2>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-1">
                        <a href="{{ route('user.show', $actuality['userId']) }}">
                            <img src="{{ asset($actuality['userAvatar']) }}" alt="logo" width="35" height="35"/>
                        </a>
                    </div>
                    <div class="col-md-10" style="margin-left: 10px;">
                        <a href="{{ route('user.show', $actuality['userId']) }}"
                           class="font-bold">{{ $actuality['userName'] }}</a>
                        {!! $actuality['content'] !!}
                        @if($actuality['userId'] == $auth->id || $auth->hasRole('admin'))
                            <a href="{{ route('actuality.delete', $actuality['actualityId']) }}" class="text-danger" style="float: right;">
                                <span class="fa fa-times"></span>
                            </a>
                        @endif
                        <p style="margin-top: 10px; font-size: 10px;" class="font-bold">
                            {{ $actuality['createdAt'] }}
                        </p>
                    </div>
                </div>
                <hr>
                @if(count($actuality['posts']) > 0)
                    @foreach($actuality['posts'] as $post)
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-1">
                                <a href="{{ route('user.show', $post['userId']) }}">
                                    <img src="{{ asset($post['userAvatar']) }}" alt="logo" width="35" height="35"/>
                                </a>
                            </div>
                            <div class="col-md-10" style="margin-left: 10px;">
                                <a href="{{ route('user.show', $post['userId']) }}"
                                   class="font-bold">{{ $post['userName'] }}</a>
                                {!! $post['content'] !!}
                                @if($post['photo'])
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="text-center">
                                                <img src="{{ asset($post['photo']) }}"
                                                     class="img-rounded" alt="photo" width="100" height="100"/>
                                            </div>

                                        </div>
                                    </div>
                                @endif
                                @if($post['userId'] == $auth->id || $auth->hasRole('admin'))
                                    <a href="{{ route('post.delete', $post['postId']) }}" class="text-danger" style="float: right;">
                                        <span class="fa fa-times"></span>
                                    </a>
                                @endif
                                <p style="margin-top: 10px; font-size: 10px;" class="font-bold">
                                    {{ $post['createdAt'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif
                @include('post.createActuality')
            </div>
        </div>
    @endforeach

@else
    <h2 class="text-center text-danger">
        Pas encore d'actualité
    </h2>
@endif