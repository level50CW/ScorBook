@extends('layout.main')

@section('header')
    {!! Html::style('/css/forgot.css') !!}
@stop

@section('content')
    <h1>Forgot Username or Password</h1>
    @include('errors.list')
    <div class="ui-forgot">
        {!! Form::open(['action'=>'Auth\AuthController@postForgot']); !!}
            @if (isset($success))
                <div><label>Password successfully reset.<br/>New password have been sent on you email.</label></div>
                <br/>
                <div align="center">
                    <a href="{{action('Auth\AuthController@getLogin')}}">
                        {!! Form::button('Cancel', ['class'=>'ui-button']); !!}
                    </a>
                </div>
            @else
                @if (isset($email))
                    <div>
                        <div><label>Your <span>username</span> is entered in the field. Press <span>Reset</span> to retrieve email with new password.</label></div>
                        <div> {!! Form::text('email',$email); !!} </div>
                    </div>
                @else
                    <div>
                        <div><label>Please enter your <span>email</span> and we will check if valid.</label></div>
                        <div> {!! Form::text('email'); !!} </div>
                    </div>
                @endif
                @if (isset($errors) && count($errors)>0)
                    <div>
                        <div><label>If you forgot username, please enter your <span>security code</span> and press <span>Reset</span> to retrieve email.</label></div>
                        <div> {!! Form::text('code'); !!} </div>
                    </div>
                @endif
                <br/>
                <div align="center">
                    {!! Form::submit('Reset', ['class'=>'ui-button']); !!}
                    <a href="{{action('Auth\AuthController@getLogin')}}">
                        {!! Form::button('Cancel', ['class'=>'ui-button']); !!}
                    </a>
                </div>
            @endif
        {!! Form::close(); !!}
    </div>
@stop