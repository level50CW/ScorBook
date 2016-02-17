<?php
$team="home";
?>

@extends('game.update.statistics')

@section('header-sub-part')
    {!! Html::style('/css/update/statistics/player.css') !!}
@stop

@section('content-statistics')
    <h1>#{{$player['number']}} {{strtoupper($player['name'])}} &ndash; PROFILE</h1>
    @include('errors.list')
    <div class="ui-statistics-content">
            <div class="ui-statistic-menu">
                <span class="ui-statistic-menu-title">STATS</span>
                <div class="ui-buttons" selected="1" radius="right">
                    <a href="{{action('StatisticController@roster',[$game->idgame, $team])}}">Roster</a>
                </div>
                <div class="ui-buttons" radius="left">
                    <a href="{{action('StatisticController@stats',[$game->idgame, $team, 'game', 'batting'])}}">Stats</a>
                </div>
            </div>

            <div class="ui-profile-green">PROFILE</div>
        <div class="ui-profile">
            <img class="ui-profile-image" src={{strtoupper($player['birthdate'])}}>
            <div class="ui-profile-data">
                <span>Position: <span> </span></span>
                <span>Birthday: <span>{{strtoupper($player['birthdate'])}}</span></span>
                <span>Hometown: <span>{{strtoupper($player['hometown'])}}</span></span>
                <span>Country: <span> </span></span>
                <span>Bats/Throws: <span>{{strtoupper($player['bats_throws'])}}</span></span>
            </div>
            <div class="ui-profile-data">
                <span>Height: <span>{{strtoupper($player['height'])}}</span></span>
                <span>Weight: <span>{{strtoupper($player['weight'])}}</span></span>
                <span>Class: <span>{{strtoupper($player['class'])}}</span></span>
                <span>College: <span>{{strtoupper($player['college'])}}</span></span>
            </div>
        </div>
    </div>
@stop