@extends('layouts.admin')


@section('content')

    <h1>Edit Users</h1>
    <div class="row">
        <div class="col-sm-3">

            <img  src="{{$user->photo ? $user->photo->path : 'No photo'}}" alt="" class="img-responsive img-rounded">

        </div>

        <div class="col-sm-9">

            {!! Form::model($user,['method'=>'PATCH','action'=>['AdminUsersController@update',$user->id], 'files'=>'true']) !!}

            <div class="form-group">
                {!! Form::label('name','Name') !!}
                {!! Form::text('name',null,['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('email','Email') !!}
                {!! Form::email('email',null,['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('role_id','Role') !!}
                {!! Form::select('role_id',$roles,null,['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('is_active','Status') !!}
                {!! Form::select('is_active',array(1=>'Active', 0=>'Not Active'),null,['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('file','File') !!}
                {!! Form::file('file',null,['class'=>'btn btn-default']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password','Password') !!}
                {!! Form::password('password',['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Update User',['class'=>'btn btn-primary col-sm-6']) !!}
            </div>

            {!! Form::close() !!}

            {!! Form::open(['method'=>'DELETE','action'=>['AdminUsersController@destroy',$user->id]]) !!}
            <div class="form-group">
                {!! Form::submit('Delete User',['class'=>'btn btn-danger col-sm-6'])!!}
            </div>
            {!! Form::close() !!}

        </div>
    </div>
    <div class="row">
        {{--napravili smo folder za greske u kome se naliz kod za ispis gresaka i posle smo ga samo inkludovali--}}
        @include('includes.form_error')

    </div>
@stop