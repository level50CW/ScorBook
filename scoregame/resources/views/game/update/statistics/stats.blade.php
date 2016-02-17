<?php
$teamName = [
        'home'=>$game->teamHome->Name,
        'visitor'=>$game->teamVisitor->Name
];

?>

@extends('game.update.statistics')

@section('header-sub-part')
    {!! Html::style('/css/update/statistics/stats.css') !!}
@stop

@section('content-statistics')
    <h1>STATISTICS &ndash; {{$teamName['visitor']}} at {{$teamName['home']}}</h1>
    @include('errors.list')
    <div class="ui-statistics-content">
    <div>
        <div class="ui-statistic-menu">
            <span class="ui-statistic-menu-title">Box score</span>
            <div class="ui-buttons" radius="right">
                <a href="{{action('StatisticController@roster',[$game->idgame, $team])}}">Roster</a>
            </div>
            <div class="ui-buttons" selected="1" radius="left">
                <a href="{{action('StatisticController@stats',[$game->idgame, $team, $period, $type])}}">Stats</a>
            </div>
        </div>

        <div class="ui-statistic-menu" style="margin-top:10px">
            <div>
                <div class="ui-buttons" radius="right" selected="{{$type=='pitching'}}">
                    <a href="{{action('StatisticController@stats',[$game->idgame, $team, $period, 'pitching'])}}">Pitching</a>
                </div>
                <div class="ui-buttons" selected="{{$type=='fielding'}}">
                    <a href="{{action('StatisticController@stats',[$game->idgame, $team, $period, 'fielding'])}}">Fielding</a>
                </div>
                <div class="ui-buttons" selected="{{$type=='batting'}}" radius="left">
                    <a href="{{action('StatisticController@stats',[$game->idgame, $team, $period, 'batting'])}}">Batting</a>
                </div>
            </div>
            <div>
                <div class="ui-buttons" radius="right" selected="{{$period=='season'}}">
                    <a href="{{action('StatisticController@stats',[$game->idgame, $team, 'season', $type])}}">Season</a>
                </div>
                <div class="ui-buttons" radius="left" selected="{{$period=='game'}}">
                    <a href="{{action('StatisticController@stats',[$game->idgame, $team, 'game', $type])}}">Game</a>
                </div>
            </div>
            <div>
                <div class="ui-buttons" radius="right" selected="{{$team=='visitor'}}">
                    <a href="{{action('StatisticController@stats',[$game->idgame, 'visitor', $period, $type])}}">Visitor</a>
                </div>
                <div class="ui-buttons" selected="{{$team=='home'}}" radius="left">
                    <a href="{{action('StatisticController@stats',[$game->idgame, 'home', $period, $type])}}">Home</a>
                </div>
            </div>
        </div>

    </div>
    <h2>{{$teamName[$team]}} &ndash; <span style="font-family: 'Helvetica Neue Bold',Helvetica">{{ucfirst($period)}} </span> &ndash; {{ucfirst($type)}} Statistics</h2>
    <div>
        <table class="ui-stats">
            @if(isset($stats) && count($stats)>0)
                <tr>
                    <th style="padding-left:5px">#</th>
                    <th class="ui-player-name">PLAYER</th>
                    @foreach($keys as $key)
                        <th>{{$key}}</th>
                    @endforeach
                </tr>
                @foreach($stats as $stat)
                    <tr class="ui-players">
                        <td style="padding-left:5px">{{$stat->Number}}</td>
                        <td>
                            <a href="{{action('StatisticController@player',[$game->idgame, $stat->Players_idplayer, $period])}}">
                                {{$stat->Lastname}}, {{$stat->Firstname[0]}}
                            </a>
                        </td>
                        @foreach($keys as $key)
                            <td>{{$stat->$key}}</td>
                        @endforeach
                    </tr>
                @endforeach
                <tr class="ui-totals">
                    <td colspan="2" class="ui-total-col">TOTALS</td>
                    @foreach($keys as $key)
                        <td>{{$totals[$key]}}</td>
                    @endforeach
                </tr>
            @else
                <tr>
                    <td>No results</td>
                </tr>
            @endif
        </table>
    </div>
    </div>
@stop