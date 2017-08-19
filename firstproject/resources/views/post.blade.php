@extends('layouts.blog-post')

@section('content')


    <!-- Blog Post -->

    <!-- Title -->
    <h1>{{$post->title}}</h1>

    <!-- Author -->
    <p class="lead">
        by <a href="{{route('admin.comments.index')}}">{{$post->user->name}}</a>
    </p>

    <hr>

    <!-- Date/Time -->
    <p><span class="glyphicon glyphicon-time"></span> Posted {{$post->created_at->diffForHumans()}}</p>

    <hr>

    <!-- Preview Image -->
    <img class="img-responsive center-block" src="{{$post->photo->path}}" alt="Post photo">

    <hr>

    <!-- Post Content -->
    <p><h2>{{$post->body}}</h2></p>

    <hr>

    @if(Session::has('comment_message'))

        {{session('comment_message')}}

    @endif
    <!-- Blog Comments -->

    @if(Auth::check())
    <!-- Comments Form -->
    <div class="well">
        <h4>Leave a Comment:</h4>
        {!! Form::open(['method'=>'POST','action'=>'PostCommentsController@store']) !!}
        <input type="hidden" name="post_id" value="{{$post->id}}">
            <div class="form-group">
                {!! Form::label('body','Body') !!}
                {!! Form::textarea('body',null,['class'=>'form-control', 'rows'=>3]) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Submit Comment',['class'=>'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>
    @endif

    <hr>

    <!-- Posted Comments -->
    @if(count($comments) > 0)
    <!-- Comment -->
        @foreach($comments as $comment)
            <div class="media">
                <a class="pull-left" href="#">
                    <img width="50" height="50" class="media-object" src="{{$comment->photo}}" alt="Comment Photo">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">{{$comment->author}}
                        <small>{{$comment->created_at->diffForHumans()}}</small>
                    </h4>
                    {{$comment->body}}
                    <button class="toggle-reply btn btn-primary pull-right">Reply</button>
                    @if(count($comment->replies)  > 0)
                        @foreach($comment->replies as $reply)
                            @if($reply->is_active == 1)
                            <!-- Nested Comment -->
                                <div id="nested-comment" class="media">
                                    <a class="pull-left" href="#">
                                        <img width="50" height="50" class="media-object" src="{{$reply->photo}}" alt="">
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading">{{$reply->author}}
                                            <small>{{$reply->created_at->diffForHumans()}}</small>
                                        </h4>
                                        {{$reply->body}}
                                    </div>
                                    <!-- End Nested Comment -->
                                </div>
                            @endif
                        @endforeach
                     @endif
                    <div class="hidden-reply">
                        {{Form::open(['method'=>'POST', 'action'=>'CommentRepliesController@createReply'])}}
                        <input type="hidden" name="comment_id" value="{{$comment->id}}">
                        <div class="form-group">
                            {!! Form::label('body','Body') !!}
                            {!! Form::textarea('body',null,['class'=>'form-control','rows'=>1]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Submit',['class'=>'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
@section('scripts')

    <script>
        $(".toggle-reply ").click(function() {
            $(".hidden-reply").toggle('slow');
        });
    </script>

@endsection

