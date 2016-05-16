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
    {!! Html::style('/css/update/scorepad_cell.css') !!}
@stop

@section('content-form')
    <h1>{{$header}}</h1>
    @include('errors.list')
    <div class="js-scorepad" team="{{$team}}">
        <div class="ui-scorepad-controls">
            <div class="js-scorepad-button-prev" style="display: none;">&blacktriangleleft;</div>
            <div class="js-scorepad-button-next" style="left: 622px; display: none;">&blacktriangleright;</div>
        </div>
        <table class="ui-score">
            @if(isset($batters) && count($batters)>=9)
            <tr class="js-scorepad-innings">
                <th style="width: 25px;"></th>
                <th style="width: 180px;">PLAYER</th>
                <th>P</th>
                <th style="width: 25px;">I</th>
            </tr>
            @foreach($batters as $batter)
                    <?php
                    $inning = ($batter->Inning >> 3).( ($batter->Inning & 7) > 0? '.'.($batter->Inning & 7) : '');
                    ?>
                @if ($batter->BatterPosition<=9)
                <tr class="js-scorepad-batter" batter="{{$batter->BatterPosition}}" player="{{$batter->idbatter}}">
                    <td>{{$batter->Number}}</td>
                    <td>{{$batter->player->getFullName()}}</td>
                    <td>{{$batter->getDefensePosition()}}</td>
                    <td>{{$inning}}</td>
                </tr>
                @endif
            @endforeach
            @endif
        </table>
    </div>
@stop

@section('script')
    @if(isset($batters) && count($batters)>=9)

        {!! Html::script('/scripts/atbat/request.js') !!}
        {!! Html::script('/scripts/atbat/storage.js') !!}
        {!! Html::script('/scripts/atbat/scorepad.js') !!}

        <script>
            G = window.G || {};
            G.gameId = {{$game->idgame}};
            G.token = '{{csrf_token()}}';
            G.baseUrl = '{{URL::to('/')}}';
        </script>


        {!! Html::script('/scripts/update/scorepad.js') !!}
    @endif
@stop
