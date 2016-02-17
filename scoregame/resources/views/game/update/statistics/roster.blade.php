<?php
$teamName = [
        'home'=>$game->teamHome->Name,
        'visitor'=>$game->teamVisitor->Name
];
?>

@extends('game.update.statistics')

@section('header-sub-part')
    {!! Html::style('/css/update/statistics/roster.css') !!}
@stop

@section('content-statistics')
    <h1>{{strtoupper($teamName[$team])}} &ndash; ROSTER</h1>
    @include('errors.list')
    <div class="ui-statistics-content">
        @foreach($roster as $groupName=>$group)
            @if($groupName == 'pitchers')
                <div class="ui-group" type={{ucfirst($groupName)}}>
                    <div class="ui-statistic-menu">
                        <span class="ui-statistic-menu-title">{{ucfirst($groupName)}}</span>

                        <div class="ui-buttons" selected="1" radius="right">
                            <a href="{{action('StatisticController@roster',[$game->idgame, $team])}}">Roster</a>
                        </div>
                        <div class="ui-buttons" radius="left">
                            <a href="{{action('StatisticController@stats',[$game->idgame, $team, 'game', 'batting'])}}">Stats</a>
                        </div>

                        <div class="ui-buttons" radius="right" selected="{{$team=='visitor'}}">
                            <a href="{{action('StatisticController@roster',[$game->idgame, 'visitor'])}}">Visitor</a>
                        </div>
                        <div class="ui-buttons" radius="left" selected="{{$team=='home'}}">
                            <a href="{{action('StatisticController@roster',[$game->idgame, 'home'])}}">Home</a>
                        </div>
                    </div>
                </div>
            @else
            <div class="ui-group" type={{ucfirst($groupName)}}>
                <div class="ui-statistic-menu">
                    <span class="ui-statistic-menu-title">{{ucfirst($groupName)}}</span>
                </div>
            </div>
            @endif

            @if(count($group)>0)
                @if($groupName == 'staff')
                    <table class="ui-roster-table">
                        <tr>
                            <th>#</th>
                            <th>PLAYER</th>
                            <th></th>
                        </tr>
                        @foreach($group as $player)
                            <tr>

                                <td font="medium" type="number">{{$player['number']}}</td>
                                <td font="medium" type="name">
                                    <a href="{{action('StatisticController@player',[$game->idgame, $player['id'], 'season'])}}">
                                        {{$player['name']}}
                                    </a>
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <table class="ui-roster-table">
                        <tr>
                            <th>#</th>
                            <th>PLAYER</th>
                            <th>B/T</th>
                            <th>H-T</th>
                            <th>W-T</th>
                            <th>COLLEGE</th>
                            <th>CLASS</th>
                            <th>HOMETOWN</th>
                        </tr>
                        @foreach($group as $player)
                            <tr>
                                <td font="medium" type="number" >{{$player['number']}}</td>
                                <td font="medium" type="name">
                                    <a href="{{action('StatisticController@player',[$game->idgame, $player['id'], 'season'])}}">
                                        {{$player['name']}}
                                    </a>
                                </td>
                                <td type="B/T">{{$player['bats_throws']}}</td>
                                <td type="H-T">{{$player['height']}}</td>
                                <td type="W-T">{{$player['weight']}}</td>
                                <td type="college">{{$player['college']}}</td>
                                <td type="class">{{$player['class']}}</td>
                                <td>{{$player['hometown']}}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            @endif
        @endforeach

    </div>
@stop