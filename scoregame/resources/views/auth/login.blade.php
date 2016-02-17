@extends('layout.main')

@section('header')
    {!! Html::style('/css/login.css') !!}
@stop

@section('content')
    <h1>Login</h1>
    @include('errors.list')
    <div class="ui-message">
        Please enter your Username and Password below.
    </div>
    <div class="ui-login">
        {!! Form::open(['action'=>'Auth\AuthController@postLogin']); !!}
        <div>
            <div> {!! Form::label('email','Username:'); !!} </div>
            <div> {!! Form::text('email'); !!} </div>
        </div>
        <div>
            <div> {!! Form::label('password','Password:'); !!} </div>
            <div> {!! Form::password('password'); !!} </div>
        </div>
        <div>
            {!! Form::checkbox('remember'); !!}
            {!! Form::label('remember','Remember me'); !!}
        </div>
        <div>
            <a href="{{action('Auth\AuthController@getForgot')}}">Forgot your username or password?</a>
        </div>
        <br/>
        <div align="center">
            {!! Form::submit('Login', ['class'=>'ui-button']); !!}
        </div>
        {!! Form::close(); !!}
    </div>
@stop