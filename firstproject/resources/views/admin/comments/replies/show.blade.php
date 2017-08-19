@extends('layouts.admin')
@section('content')
    @if(count($replies) > 0)
        <h1>Replies</h1>
        <table class="table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Author</th>
                <th>Email</th>
                <th>Body</th>
                <th>Post title</th>
                <th>Post</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($replies as $reply)
                <tr>
                    <td>{{$reply->id}}</td>
                    <td>{{$reply->author}}</td>
                    <td>{{$reply->email}}</td>
                    <td>{{$reply->body}}</td>
                    <td>{{$reply->comment->post->title}}</td>
                    <td><a href="{{route('home.post',$reply->comment->post->id)}}">View</a></td>
                    <td>

                        @if($reply->is_active==1)
                            {!! Form::open(['method'=>'PATCH','action'=>['CommentRepliesController@update', $reply->id]]) !!}

                            <input type="hidden" name="is_active" value="0">

                            {!! Form::submit('Un-approve',['class'=>'btn btn-info']) !!}

                            {!! Form::close() !!}
                        @else
                            {!! Form::open(['method'=>'PATCH','action'=>['CommentRepliesController@update', $reply->id]]) !!}

                            <input type="hidden" name="is_active" value="1">

                            {!! Form::submit('Approve',['class'=>'btn btn-success']) !!}

                            {!! Form::close() !!}
                        @endif
                    </td>
                    <td>

                        {!! Form::open(['method'=>'DELETE','action'=>['CommentRepliesController@destroy', $reply->id]]) !!}

                        <input type="hidden" name="is_active" value="1">

                        {!! Form::submit('Delete',['class'=>'btn btn-danger']) !!}

                        {!! Form::close() !!}

                    </td>
                </tr>
            </tbody>
            @endforeach
        </table>
        <div class="row">
            <div class="text-center">
                {{$replies->render()}}
            </div>
        </div>
    @else
        <h1 class="text-center">No replies For This Post</h1>
    @endif
@endsection