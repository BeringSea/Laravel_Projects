@extends('layouts.admin')
@section('content')

    <h1>Edit Post</h1>

    <div class="row">
            <div class="col-sm-3">
                <img class="img-responsive img-rounded" width="300" height="300" src="{{$post->photo->path}}" alt="">
            </div>
            <div class="col-sm-9">
                    {!! Form::model($post,['method'=>'PATCH','action'=>['AdminPostsController@update',$post->id],'files'=>'true']) !!}
                <input type="hidden" name="user_id" value="{{$post->user->id}}">
                <div class="form-group">
                    {!! Form::label('title','Title') !!}
                    {!! Form::text('title',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('category_id','Category') !!}
                    {!! Form::select('category_id', $categories,null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('photo_id','File') !!}
                    {!! Form::file('photo_id',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('body','Description') !!}
                    {!! Form::textarea('body',null,['class'=>'form-control','rows'=> 7]) !!}
                </div>
                <div class="form-group">
                    {!! Form::submit('Update Post',['class'=>'btn btn-primary col-sm-6']) !!}
                </div>
                {!! Form::close() !!}
                {!! Form::open(['method'=>'DELETE','action'=>['AdminPostsController@destroy',$post->id]])!!}
                    {!! Form::submit('Delete Post',['class'=>'btn btn-danger col-sm-6']) !!}
                {!! Form::close() !!}
        </div>
    </div>
    <div class="row">
        @include('includes.form_error')
    </div>

@endsection