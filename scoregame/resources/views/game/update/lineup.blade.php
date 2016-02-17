<?php
use \App\Models\Batter;

$goTo = [
        'home'=>'Visitor',
        'visitor'=>'Home'
];

$title = [
        'visitor'=>'Visiting Team Line Up &ndash; '.$lineup->team->Name,
        'home'=>'Home Team Line Up &ndash; '.$lineup->team->Name
];

$goTo = $goTo[$team];
$title = $title[$team];
?>

@extends('game.update')

@section('header-part')
    {!! Html::style('/css/update/lineup.css') !!}
@stop

@section('content-form')
    <h1>{{$title}}</h1>
    <div>
        @include('errors.list')
    {!!Form::open(['url'=>action('LineupController@store',[$game->idgame, $team])])!!}

        <h2></h2>
        <table class="ui-table-lineupheader">
            <tr>
                <th style="width: 56px;">#</th>
                <th style="width: 338px;">Player Name</th>
                <th>Pos</th>
                <th>Inn</th>
                <th style="width: 17px;"></th>
            </tr>
        </table>

        @foreach($battersByBatPosition as $key => $batters)
            <div class="js-player-container" align="center" batter="{{$key}}">
                @if ($key == 10)
                    <h2>Pitcher</h2>
                @else
                    <h2>Batter {{$key}}</h2>
                @endif


                @foreach($batters as $batter)
                    <div class="ui-row ui-gray-player">
                        {!! Form::hidden('BatterPosition[]',$batter->BatterPosition) !!}
                        {!! Form::text('Number[]', $batter->Number, ['class'=>'ui-small', 'maxlength'=>2]) !!}

                        <div class="ui-gray-player-name">
                            {!! Form::select('player[]',$players,$batter->player->idplayer,['class'=>'ui-large']) !!}
                        </div>

                        @if ($batter->BatterPosition == 10)
                            {!! Form::select('DefensePosition[]',
                                            [array_flip(Batter::$defensePositions)['P']=>'P'],
                                            $batter->DefensePosition,
                                            ['class'=>'js-defense-position ui-medium']) !!}
                        @else
                            {!! Form::select('DefensePosition[]',
                                            Batter::$defensePositions,
                                            $batter->DefensePosition,
                                            ['class'=>'js-defense-position ui-medium']) !!}
                        @endif
                        {!! Form::text('Inning[]', $batter->Inning, ['class'=>'ui-small', 'maxlength'=>2]) !!}
                        <div class="ui-remove-substitution">x</div>
                    </div>
                @endforeach
                <a href="#" class="js-enter-substitution" style="color: #ADADAD;">Enter Substitution</a>
            </div>
        @endforeach

        <br/>
        <div class="ui-row">
            {!! Form::submit("Update and Change to $goTo Line Up", ['class'=>'ui-button']) !!}
        </div>
    {!!Form::close()!!}
    </div>
    <div class="js-player-template" style="display: none">
        <div class="ui-row ui-gray-player">
            {!! Form::hidden('BatterPosition[]',0,['class'=>'js-batter-position']) !!}
            {!! Form::text('Number[]', 1, ['class'=>'ui-small', 'maxlength'=>2]) !!}

            <div class="ui-gray-player-name">
                {!! Form::select('player[]',$players,null,['class'=>'ui-large']) !!}
            </div>

            {!! Form::select('DefensePosition[]',
                            Batter::$defensePositions,
                            null,
                            ['class'=>'js-defense-position ui-medium']) !!}
            {!! Form::text('Inning[]', 1, ['class'=>'ui-small', 'maxlength'=>2]) !!}
            <div class="ui-remove-substitution">x</div>
        </div>
    </div>
@stop

@section('script')
    {!! Html::script('/scripts/update/lineup.js') !!}
@stop