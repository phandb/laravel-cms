@extends('layouts.admin')



@section('content')

<h1>Edit User</h1>

<div class="row">

    <div class="col-sm-3">

        <img src="{{$user->photo ? $user->photo->file : 'http://placehold.it/200x200'}}" alt="" class="img-responsive img-rounded">

    </div>


    <div class="col-sm-9">
    {!! Form::model($user, ['method'=>'PATCH', 'action'=> ['AdminUsersController@update', $user->id ],'files'=>true]) !!}
        <div class="form-group">
            {!! Form::label('name', 'Name:') !!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('email', 'Email:') !!}
            {!! Form::email('email', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('role_id', 'Role:') !!}
            {!! Form::select('role_id', $roles, null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('is_active', 'Status:') !!}
            <!--Set status either active or not active with default of not active-->
            {!! Form::select('is_active', array(1 => 'Acive', 0 => 'Not Active'), null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('photo_id', 'Choose File:') !!}
            {!! Form::file('photo_id', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('password', 'Password:') !!}
            
            {!! Form::password('password',  ['class'=>'form-control']) !!}
        </div>





        <div class="form-group">
            
            {!! Form::submit('Edit User', ['class'=>'btn btn-primary col-sm-2'])!!}
        </div>

        {!! Form::close() !!}




        {!! Form::open(['method'=>'DELETE', 'action'=> ['AdminUsersController@destroy', $user->id]]) !!}

            <div class="form-group">

                {!! Form::submit('Delete User', ['class'=>'btn btn-danger col-sm-2 pull-right']) !!}
            </div>

        {!! Form::close() !!}

    </div>

</div>

<div class="row">
    <!--We create form error and save in resources/views/includes folder under file
    name form_error.blade.php-->

@include('includes.form_error')

</div>



@stop