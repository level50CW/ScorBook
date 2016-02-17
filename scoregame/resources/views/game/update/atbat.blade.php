@extends('game.update')

@section('header-part')
    {!! Html::style('/css/update/atbat.css') !!}
@stop

@section('content-form')
    @include('errors.list')
@stop