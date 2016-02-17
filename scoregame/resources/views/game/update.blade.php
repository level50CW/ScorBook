@extends('layout.main')

@section('header')
    {!! Html::style('/css/update.css') !!}
    @yield('header-part')
@stop

@section('content')
    @yield('content-form')
@stop

@section('menu')
    @include('layout.menu')
@stop