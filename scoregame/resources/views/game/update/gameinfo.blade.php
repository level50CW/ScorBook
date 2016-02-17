<?php
use App\Helpers\LocalDateTime;
?>

@extends('game.update')

@section('header-part')
    {!! Html::style('/css/update/gameinfo.css') !!}
@stop

@section('content-form')
    <h1>Score Game &ndash; {{$game->teamVisitor->Name}} at {{$game->teamHome->Name}}</h1>

<div>
    @include('errors.list')
    {!!Form::model($game,['url'=>action('GameController@store',$game->idgame)])!!}

    <h2>GAME INFO</h2>
    <div class="ui-row">
        <div class="ui-label ui-green">{!!Form::label('date','Date:')!!} <span class="ui-required">*</span></div>
        <div class="ui-gray">{!!LocalDateTime::fromCarbonToInput($game->getDate(),['name'=>'date', 'disabled'=>'disabled', 'type'=>'text'])!!}</div>
    </div>
    <div class="ui-row">
        <div class="ui-label ui-brown">{!!Form::label('season','Season:')!!} <span class="ui-required">*</span></div>
        <div class="ui-gray">{!!Form::text('season',$game->season->season, ['disabled'=>'disabled'])!!}</div>
    </div>
    <div class="ui-row">
        <div class="ui-label ui-green">{!!Form::label('status','Status:')!!} <span class="ui-required">*</span></div>
        <div class="ui-gray">{!!Form::select('status',$game->statuses)!!}</div>
    </div>


    <h2>HOME TEAM</h2>
    <div class="ui-row">
        <div class="ui-label ui-green">{!!Form::label('homeDivisionName','Division:')!!} <span class="ui-required">*</span></div>
        <div class="ui-gray">{!!Form::text('homeDivisionName',$game->teamHome->division->Name, ['disabled'=>'disabled'])!!}</div>
    </div>
    <div class="ui-row">
        <div class="ui-label ui-brown">{!!Form::label('homeTeamName','Team:')!!} <span class="ui-required">*</span></div>
        <div class="ui-gray">{!!Form::text('homeTeamName',$game->teamHome->Name, ['disabled'=>'disabled'])!!}</div>
    </div>
    <div class="ui-row">
        <div class="ui-label ui-green">{!!Form::label('homeStadium','Stadium:')!!} <span class="ui-required">*</span></div>
        <div class="ui-gray">{!!Form::text('homeStadium',$game->teamHome->location, ['disabled'=>'disabled'])!!}</div>
    </div>


    <h2>VISITING TEAM</h2>
    <div class="ui-row">
        <div class="ui-label ui-green">{!!Form::label('visitingDivisionName','Division:')!!} <span class="ui-required">*</span></div>
        <div class="ui-gray">{!!Form::text('visitingDivisionName',$game->teamVisitor->division->Name, ['disabled'=>'disabled'])!!}</div>
    </div>
    <div class="ui-row">
        <div class="ui-label ui-brown">{!!Form::label('visitingTeamName','Team:')!!} <span class="ui-required">*</span></div>
        <div class="ui-gray">{!!Form::text('visitingTeamName',$game->teamVisitor->Name, ['disabled'=>'disabled'])!!}</div>
    </div>


    <h2>CONDITIONS</h2>
    <div class="ui-row">
        <div class="ui-label ui-green">{!!Form::label('comment','Comment:')!!}</div>
        <div class="ui-gray">{!!Form::text('comment',null)!!}</div>
    </div>
    <div class="ui-row">
        <div class="ui-label ui-green">{!!Form::label('attendance','Attendance:')!!}</div>
        <div class="ui-gray">{!!Form::text('attendance',null)!!}</div>
    </div>
    <div class="ui-row">
        <div class="ui-label ui-green">{!!Form::label('weather','Weather:')!!} <span class="ui-required">*</span></div>
        <div class="ui-gray">{!!Form::select('weather',$game->weathers)!!}</div>
    </div>
    <div class="ui-row">
        <div class="ui-label ui-green">{!!Form::label('temperature','Temperature:')!!} <span class="ui-required">*</span></div>
        <div class="ui-gray">{!!Form::text('temperature',null, ['style'=>'width: 45px;margin-left: -145px;'])!!} F</div>
    </div>


    <h2>OFFICIALS</h2>
    <div class="ui-row">
        <div class="ui-label ui-brown">{!!Form::label('Plateump','Plate Ump:')!!} <span class="ui-required">*</span></div>
        <div class="ui-gray">{!!Form::text('Plateump',null)!!}</div>
    </div>
    @for($i=1;$i<=5;$i++)
        <div class="ui-row">
            <div class="ui-label ui-brown">{!!Form::label('Fieldump'.$i,"Field Ump $i:")!!} @if ($i<=$numberUmps)<span class="ui-required">*</span> @endif </div>
            <div class="ui-gray">{!!Form::text('Fieldump'.$i,null)!!}</div>
        </div>
    @endfor
    <br/>
    <div class="ui-row">
        {!!Form::submit('Update',['class'=>'ui-button'])!!}
        <a href="{{action('GameController@index')}}">
            {!!Form::button('Cancel',['class'=>'ui-button'])!!}
        </a>
    </div>

    {!!Form::close()!!}
</div>
@stop