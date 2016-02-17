@extends('game.update')

@section('header-part')
    {!! Html::style('/css/update/statistics.css') !!}
    @yield('header-sub-part')
@stop

@section('content-form')
    {!! Html::script('/scripts/statistic/statistics.js') !!}
    <div>
        @yield('content-statistics')
    </div>
@stop