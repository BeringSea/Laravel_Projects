@extends('layouts.admin')
@section('content')
    @if(count($comments) > 0)
        <h1>Comments</h1>
        <table class="table">
            <thead>
              <tr>
                <th>Id</th>
                <th>Author</th>
                <th>Email</th>
                <th>Body</th>
                <th>Post title</th>
                <th>Post</th>
                <th>Reply</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            @foreach($comments as $comment)
              <tr>
                <td>{{$comment->id}}</td>
                <td>{{$comment->author}}</td>
                <td>{{$comment->email}}</td>
                <td>{{$comment->body}}</td>
                <td>{{$comment->post->title}}</td>
                <td><a href="{{route('home.post',$comment->post->id)}}">View</a></td>
                <td><a href="{{route('admin.comment.replies.show', $comment->id)}}">View</a></td>
                <td>

                    @if($comment->is_active==1)
                        {!! Form::open(['method'=>'PATCH','action'=>['PostCommentsController@update', $comment->id]]) !!}

                        <input type="hidden" name="is_active" value="0">

                            {!! Form::submit('Un-approve',['class'=>'btn btn-info']) !!}

                        {!! Form::close() !!}
                        @else
                        {!! Form::open(['method'=>'PATCH','action'=>['PostCommentsController@update', $comment->id]]) !!}

                        <input type="hidden" name="is_active" value="1">

                        {!! Form::submit('Approve',['class'=>'btn btn-success']) !!}

                        {!! Form::close() !!}
                    @endif
                </td>
                <td>

                    {!! Form::open(['method'=>'DELETE','action'=>['PostCommentsController@destroy', $comment->id]]) !!}

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
                {{$comments->render()}}
            </div>
        </div>
        @else
            <h1 class="text-center">No Comments For This Post</h1>
    @endif
@endsection