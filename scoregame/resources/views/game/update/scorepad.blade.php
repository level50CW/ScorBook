<?php
$header = [
        'home'=>'Score Pad &ndash; Home &ndash; '.$game->teamHome->Name,
        'visitor'=>'Score Pad &ndash; Visitors &ndash; '.$game->teamVisitor->Name
];

$header = $header[$team];

?>

@extends('game.update')

@section('header-part')
    {!! Html::style('/css/update/scorepad.css') !!}
@stop

@section('content-form')
    <h1>{{$header}}</h1>
    @include('errors.list')
    <div>
        <table class="ui-score">
            @if(isset($batters) && count($batters)>0)
            <tr>
                <th></th>
                <th>PLAYER</th>
                <th>P</th>
                <th>I</th>
                @for($i=1; $i<=9; $i++)
                    <th>{{$i}}</th>
                @endfor
            </tr>
            @foreach($batters as $batter)
                <tr>
                    <td>{{$batter->BatterPosition}}</td>
                    <td>{{$batter->player->getFullName()}}</td>
                    <td>{{$batter->getDefensePosition()}}</td>
                    <td>{{$batter->Inning}}</td>
                    @for($i=1; $i<=9; $i++)
                        <td>
                            <div class="ui-score-button">
                                <a href="{{action('AtBatController@index',$game->idgame)}}">{!! Form::button('',['class'=>'ui-button']) !!}</a>
                            </div>
                        </td>
                    @endfor
                </tr>
            @endforeach
            @endif
        </table>
    </div>
@stop