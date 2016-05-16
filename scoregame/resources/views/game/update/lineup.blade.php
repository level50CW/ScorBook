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
                    <?php
                        $inning = ($batter->Inning >> 3).( ($batter->Inning & 7) > 0? '.'.($batter->Inning & 7) : '');
                    ?>
                    @if (($batter->Inning >> 3) <= $game->last_inning)
                        <div class="ui-row ui-gray-player">
                            {!! Form::hidden('BatterPosition[]',$batter->BatterPosition) !!}
                            {!! Form::hidden('UserChange[]',0) !!}
                            {!! Form::text('Number[]', $batter->Number, ['class'=>'ui-small js-input-player-number', 'maxlength'=>2, 'readonly'=>true]) !!}

                            <div class="ui-gray-player-name">
                                {!! Form::hidden('player[]',$batter->player->idplayer, ['class'=>'js-select-player']) !!}
                                {!! Form::text('_[]', $players[$batter->player->idplayer], ['class'=>'ui-large', 'readonly'=>true]) !!}
                            </div>

                            {!! Form::hidden('DefensePosition[]',$batter->DefensePosition, ['class'=>'js-defense-position']) !!}
                            {!! Form::text('_[]', Batter::$defensePositions[$batter->DefensePosition], ['class'=>'ui-medium', 'readonly'=>true]) !!}

                            {!! Form::text('Inning[]', $inning, ['class'=>'ui-small', 'maxlength'=>4, 'readonly'=>true]) !!}
                            <div style="display: inline-block;"></div>
                        </div>
                    @else
                        <div class="ui-row ui-gray-player">
                            {!! Form::hidden('BatterPosition[]',$batter->BatterPosition) !!}
                            {!! Form::hidden('UserChange[]',1) !!}
                            {!! Form::text('Number[]', $batter->Number, ['class'=>'ui-small js-input-player-number', 'maxlength'=>2, 'readonly'=>true]) !!}

                            <div class="ui-gray-player-name">
                                {!! Form::select('player[]',$playersRemain,$batter->player->idplayer,['class'=>'ui-large js-select-player']) !!}
                            </div>

                            {!! Form::select('DefensePosition[]',
                            Batter::$defensePositions,
                            $batter->DefensePosition,
                            ['class'=>'js-defense-position ui-medium']) !!}

                            {!! Form::text('Inning[]', $inning, ['class'=>'ui-small', 'maxlength'=>4]) !!}
                            <div class="ui-remove-substitution">x</div>
                        </div>
                    @endif
                @endforeach
                @if (count($playersRemain) > 0)
                    <a href="#" class="js-enter-substitution" style="color: #ADADAD;">Enter Substitution</a>
                @endif
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
            {!! Form::hidden('UserChange[]',1) !!}
            {!! Form::text('Number[]', 1, ['class'=>'ui-small js-input-player-number', 'maxlength'=>2, 'readonly'=>true]) !!}

            <div class="ui-gray-player-name">
                {!! Form::select('player[]',$playersRemain,null,['class'=>'ui-large js-select-player']) !!}
            </div>

            {!! Form::select('DefensePosition[]',
                            Batter::$defensePositions,
                            null,
                            ['class'=>'js-defense-position ui-medium']) !!}
            {!! Form::text('Inning[]', $game->last_inning + 1, ['class'=>'ui-small', 'maxlength'=>4]) !!}
            <div class="ui-remove-substitution">x</div>
        </div>
    </div>
@stop

@section('script')
    <script>
        G = {
            playerNumbers: {
                @foreach($numbers as $pid=>$number)
                    '{{$pid}}': {{$number}},
                @endforeach
            }
        };
    </script>
    {!! Html::script('/scripts/update/lineup.js') !!}
@stop