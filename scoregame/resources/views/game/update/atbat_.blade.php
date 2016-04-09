<?php
use \App\Models\Batter;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    {!! Html::style('/css/ui.css') !!}
    {!! Html::style('/css/update/atbat_.css') !!}
</head>
<body>
{!! Html::script('/libs/jquery/js/jquery-2.1.4.min.js') !!}
{!! Html::script('/libs/jquery-ui/jquery-ui.min.js') !!}
{!! Html::script('/libs/underscore/underscore.js') !!}
{!! Html::script('/libs/moment/moment.js') !!}
{!! Html::script('/scripts/atbat/crossbrowser.js') !!}
<div class="ui-header">
    <img src="{{url('/images/atbat/Northwoods-League-Logo.jpg')}}" class="ui-image-logo">
    <div style="margin-top: 130px;">
        @include('auth.user')
    </div>
</div>
<div class="ui-sub-header">
    <span > Score Game &ndash; {{$game->teamVisitor->Name}} at {{$game->teamHome->Name}} </span>
</div>
@include('errors.list')
@if(isset($lineupPlayers))
<div class="js-header-second ui-sub-header-second">
</div>
<div class="ui-container">

    <div>
        <div class="ui-statistic-div">
            <span class="ui-statistic-title" >{{$game->teamVisitor->Name}} (0-0) at {{$game->teamHome->Name}} (0-0)</span>
            <table class="ui-table-statistic" cellpadding="3px" cellspacing="0">
                <tr>
                    <th colspan="2" class="ui-table-statistic-head-color" selected="1">{{$game->teamVisitor->getSimpleName()}}</th>
                    <th class="ui-table-statistic-head"></th>
                    @for($i=1;$i<=9;$i++)
                        <th class="ui-table-statistic-head">{{$i}}</th>
                    @endfor
                    <th class="ui-table-statistic-head" style="padding-left:20px">R</th>
                    <th class="ui-table-statistic-head">H</th>
                    <th class="ui-table-statistic-head">E</th>
                    <th colspan="2" class="ui-table-statistic-head-color">{{$game->teamHome->getSimpleName()}}</th>
                </tr>
                <tr>
                    <td rowspan="2">
                        @if(!empty($game->teamVisitor->logo))
                            <img style="width:90px" src="{{url($game->teamVisitor->logo)}}">
                        @endif
                    </td>
                    <td rowspan="2" class="js-inning-visitor-r ui-points">0</td>
                    <td class="ui-table-statistic-body">{{$game->teamVisitor->Abv}}</td>
                    @for($i=1;$i<=9;$i++)
                        <td  class="js-inning-visitor ui-table-statistic-body-color" inning="{{$i}}"></td>
                    @endfor
                    <td class="js-inning-visitor-r ui-table-statistic-body" style="padding-left:20px">0</td>
                    <td class="js-inning-visitor-h ui-table-statistic-body">0</td>
                    <td class="js-inning-visitor-e ui-table-statistic-body">0</td>
                    <td rowspan="2" class="js-inning-home-r ui-points">0</td>
                    <td rowspan="2">
                        @if(!empty($game->teamHome->logo))
                            <img style="width:90px" src="{{url($game->teamHome->logo)}}">
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="ui-table-statistic-body">{{$game->teamHome->Abv}}</td>
                    @for($i=1;$i<=9;$i++)
                        <td  class="js-inning-home ui-table-statistic-body-color" inning="{{$i}}"></td>
                    @endfor
                    <td class="js-inning-home-r ui-table-statistic-body" style="padding-left:20px">0</td>
                    <td class="js-inning-home-h ui-table-statistic-body">0</td>
                    <td class="js-inning-home-e ui-table-statistic-body">0</td>
                </tr>
            </table>
        </div>
        <div class="ui-weather-div" style="">
            <div class="ui-stadium-name">
                <span>{{$game->teamHome->location}}</span>
            </div>
            <div class="ui-weather">
                <img src="{{url($game->weatherIcons[$game->weather])}}" class="ui-weather-icon">
                <span class="ui-weather-text"> {{$game->temperature.'° '.$game->weather}}</span>
            </div>
            <div>
                <div class="ui-button-start" onclick="G.onUpdateGameStatus(1)">
                    <div class="icon"></div>
                    <div class="text">START GAME</div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="ui-field-container">
            <div class="js-field ui-field-div">
                <canvas class="js-field-canvas"  width="700" height="340"></canvas>
                <img src="{{url('/images/atbat/img_baseball_field.png')}}" class="ui-baseball-field">
            </div>
            <div class="ui-field-label js-label-field"></div>
            <div class="js-batting-batside ui-batting-batside">
                {{--BATTING RIGHT<span class="ui-triangle" type="right"></span>--}}
                {{--<span class="ui-triangle" type="left"></span>BATTING LEFT--}}
            </div>

            <div class="ui-deck-div">
                <span class="ui-deck-text">
                   <span><span style="color: #afafaf;">AT BAT: </span><span class="js-label-atbat"></span></span>
                    <span style="display: block; padding-top: 10px"><span style="color: #afafaf;">ON DECK: </span><span class="js-label-ondeck"></span></span>
                </span>
            </div>

            <div class="ui-bso-div">
                <div style=" display: table; margin: auto;">
                    <div class="js-pitch-type ui-bso-part" type="ball">
                        <span>B</span>
                        <div class="ui-circle" value="1"></div>
                        <div class="ui-circle" value="2"></div>
                        <div class="ui-circle" value="3"></div>
                        <div class="ui-circle" value="4"></div>
                    </div>
                    <div class="js-pitch-type ui-bso-part" type="strike">
                        <span>S</span>
                        <div class="ui-circle" value="1"></div>
                        <div class="ui-circle" value="2"></div>
                        <div class="ui-circle" value="3"></div>
                    </div>
                    <div class="js-pitch-type ui-bso-part" type="out" style=" margin-right: 0px;">
                        <span>O</span>
                        <div class="ui-circle"></div>
                        <div class="ui-circle"></div>
                        <div class="ui-circle"></div>
                    </div>
                </div>
            </div>

            <div class="js-pitch-region ui-pitch-region">
                <img src="{{url('/images/atbat/img_pitch_trecking.png')}}" style="width: 100%"/>
            </div>
        </div>
        <div class="ui-buttons-container">
            <table>
                <tr>
                    <td><div class="ui-field-button js-button-field-strike-looking">Strike Looking</div></td>
                    <td><div class="ui-field-button js-button-field-ball">Ball</div></td>
                    <td rowspan="2">
                        <div class="ui-field-ballinplay js-button-pitch">
                            <div class="ui-field-ballinplay-circle"></div>
                            <div>Ball In Play</div>
                        </div>
                        <div class="js-button-pitch-menu"></div>
                    </td>
                    <td><div class="ui-field-button js-button-field-hitbypitch">Hit by Pitch</div></td>
                    <td><div class="ui-field-button js-button-field-balk">Balk</div></td>
                </tr>
                <tr>
                    <td><div class="ui-field-button js-button-field-strike-swinging">Strike Swinging</div></td>
                    <td><div class="ui-field-button js-button-field-ball-faul">Faul Ball</div></td>
                    <td><div class="ui-field-button js-button-field-out-wildpitch">Wild Pitch</div></td>
                    <td><div class="ui-field-button js-button-field-out-catcherobs">Catcher Obs</div></td>
                </tr>
            </table>
        </div>

        <div>
            <table class="ui-buttons-div">
                <tr>
                    <td><div class="ui-button-rare">Rare 1</div></td>
                    <td><div class="ui-button-rare">Rare 2</div></td>
                    <td><div class="ui-button-rare">Rare 3</div></td>
                    <td><div class="ui-button-rare">Rare 4</div></td>
                    <td><div class="ui-button-rare">Rare 5</div></td>
                    <td><div class="ui-button-rare">Rare 6</div></td>
                </tr>
            </table>
        </div>

        <div class="ui-buttons-div" style="display: none">
            <table cellspacing="10" width="100%" style="table-layout:fixed;">
                <tr style="background-color: #e89f02; text-align: center; vertical-align: middle; height:36px">
                    <td class="js-button-hit" disabled="1">HIT</td>
                    <td class="js-button-k" disabled="1">K</td>
                    <td class="js-button-outs" disabled="1">OUTS</td>
                    <td class="js-button-err" disabled="1">ERR</td>
                    <td class="js-button-steal" disabled="1">MISC</td>
                    <td class="js-button-ar" disabled="1">AR</td>
                </tr>
            </table>
        </div>

    </div>

    <div class="ui-tables-bottom-div">
        <div class="ui-tables-left-div">
            <div class="ui-container-div-title">
                <div class="js-button-container ui-button-container" style="margin-left: 15px"selected="selected" type="lineup">Lineup</div>
                <div class="js-button-container ui-button-container" style="margin-left: 30px" type="scorepad">Score Pad</div>
            </div>
            <div class="ui-lineup-div-title">
                <div class="js-button-lineup ui-button-lineup" selected="selected" team="visitor">{{$game->teamVisitor->getSimpleName()}}</div>
                <div class="js-button-lineup ui-button-lineup" style="margin-left: -4px" team="home">{{$game->teamHome->getSimpleName()}}</div>
            </div>
            <div class="js-container-lineup" style="display: none">
                @foreach($lineupPlayers as $lineupTeam)
                    <div class="js-lineup ui-command-div" style="display: none">
                        <div class="ui-caption-command">{{$lineupTeam['name']}}</div>
                        <table class="ui-table-command">
                            <tr>
                                <th colspan="2" class="ui-table-command-header">Lineup</th>
                                <th>AB</th>
                                <th>R</th>
                                <th>H</th>
                                <th>RBI</th>
                                <th>BB</th>
                                <th>SO</th>
                            </tr>
                            @foreach ($lineupTeam['lineup'] as $batter)

                                <tr class="js-lineup-batter" batter="{{$batter->BatterPosition}}">
                                    <td>{{$batter->Number}}</td>
                                    <td class="ui-table-command-player">{{$batter->player->getCutName().' '.Batter::$defensePositions[$batter->DefensePosition]}}</td>
                                    <td type="AB">0</td>
                                    <td type="R">0</td>
                                    <td type="H">0</td>
                                    <td type="RBI">0</td>
                                    <td type="BB">0</td>
                                    <td type="SO">0</td>
                                </tr>

                            @endforeach
                        </table>
                        <table class="ui-table-command">
                            <tr>
                                <th colspan="2" class="ui-table-command-header">Pitchers</th>
                                <th>IP</th>
                                <th>PC</th>
                                <th>H</th>
                                <th>R</th>
                                <th>ER</th>
                                <th>BB</th>
                                <th>SO</th>
                            </tr>
                            @foreach ($lineupTeam['oppositePitchers'] as $batter)
                                <tr class="js-lineup-pitcher" batter="{{$batter->BatterPosition}}">
                                    <td>{{$batter->Number}}</td>
                                    <td class="ui-table-command-player">{{$batter->player->getCutName().' '.Batter::$defensePositions[$batter->DefensePosition]}}</td>
                                    <td type="IP">0</td>
                                    <td type="PC">0</td>
                                    <td type="H">0</td>
                                    <td type="R">0</td>
                                    <td type="ER">0</td>
                                    <td type="BB">0</td>
                                    <td type="SO">0</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endforeach
            </div>
            <div class="js-container-scorepad" style="display: none">
                @foreach($lineupPlayers as $lineupTeam)
                    <div class="js-scorepad" style="display: none">
                        <div class="ui-caption-command">{{$lineupTeam['name']}}</div>
                        <table class="ui-table-scorepad ui-table-command">
                            <tr>
                                <th class="ui-table-command-header"></th>
                                <th style="width: 200px; text-align: left;">Player</th>
                                <th>P</th>
                                <th>I</th>
                                @for($i=1; $i<=5; $i++)
                                    <th>{{$i}}</th>
                                @endfor
                            </tr>
                            @foreach($lineupTeam['lineup'] as $batter)
                                <tr>
                                    <td>{{$batter->BatterPosition}}</td>
                                    <td style="text-align: left">{{$batter->player->getFullName()}}</td>
                                    <td>{{$batter->getDefensePosition()}}</td>
                                    <td>{{$batter->Inning}}</td>
                                    @for($i=1; $i<=5; $i++)
                                        <td>
                                            <div class="ui-score-button">
                                                <a href="{{action('AtBatController@index',$game->idgame)}}">{!! Form::button('',['class'=>'ui-button']) !!}</a>
                                            </div>
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="ui-tables-right-div">
            <div class="ui-gamelog js-container-pitch-list" style="display: none">
                <div class="js-pitch-list-controls">
                    <div class="js-left button" style="display: inline-block">&blacktriangleleft;</div>
                    <div class="js-counter pages" style="display: inline-block"></div>
                    <div class="js-right button" style="display: inline-block">&blacktriangleright;</div>
                </div>
                <div class="js-pitch-list ui-pitch-status"></div>
            </div>
        </div>
    </div>
</div>
@endif

@include('layout.menu',['atbat'=>true])
<div class="ui-footer">
    Copyright © {{date('Y')}} Northwoods League. All Rights Reserved.<br><br>
    <hr style="width:200px; margin:0 auto; height: 1px; background-color: white;">
</div>

@if(isset($lineupPlayers))
{!! Html::script('/scripts/atbat/inning.js') !!}
{!! Html::script('/scripts/atbat/pitching.js') !!}
{!! Html::script('/scripts/atbat/field.js') !!}
{!! Html::script('/scripts/atbat/hit.js') !!}
{!! Html::script('/scripts/atbat/strike.js') !!}
{!! Html::script('/scripts/atbat/out.js') !!}
{!! Html::script('/scripts/atbat/misc.js') !!}
{!! Html::script('/scripts/atbat/error.js') !!}
{!! Html::script('/scripts/atbat/advance.js') !!}
{!! Html::script('/scripts/atbat/graphics.js') !!}
{!! Html::script('/scripts/atbat/request.js') !!}
{!! Html::script('/scripts/atbat/storage.js') !!}
{!! Html::script('/scripts/atbat/ballInPlay.js') !!}
{!! Html::script('/scripts/atbat/gameLog.js') !!}
{!! Html::script('/scripts/atbat/main.js') !!}

<script>
    G.lineups = {
        visitor:{
            type: 'visitor',
            name: '{{$lineupPlayers[0]['name']}}',
            batters: [
                @foreach ($lineupPlayers[0]['lineup'] as $batter)
                    {
                        id: {{$batter->idbatter}},
                        bats: '{{$batter->player->Bats}}',
                        number: {{$batter->Number}},
                        batter: {{$batter->BatterPosition}},
                        name: '{{$batter->player->getFullName()}}',
                        position: '{{Batter::$defensePositions[$batter->DefensePosition]}}'
                    },
                @endforeach
                ],
            fielders: [
                @foreach ($lineupPlayers[0]['fielders'] as $batter)
                    {
                        id: {{$batter->idbatter}},
                        number: {{$batter->Number}},
                        name: '{{$batter->player->getFullName()}}',
                        position: '{{Batter::$defensePositions[$batter->DefensePosition]}}',
                        positionId: {{$batter->DefensePosition}}
                    },
                @endforeach
                ],
            pitchers: [
                @foreach ($lineupPlayers[0]['pitchers'] as $batter)
                {
                    id: {{$batter->idbatter}},
                    throws: '{{$batter->player->Throws}}',
                    number: {{$batter->Number}},
                    batter: {{$batter->BatterPosition}},
                    name: '{{$batter->player->getFullName()}}',
                    position: '{{Batter::$defensePositions[$batter->DefensePosition]}}'
                },
                @endforeach
            ],
            getPlayer: function(id, type){
                return _.find(this[type], function(b) {return b.id==id});
            }
            },
        home:{
            type: 'home',
            name: '{{$lineupPlayers[1]['name']}}',
            batters: [
                @foreach ($lineupPlayers[1]['lineup'] as $batter)
                {
                    id: {{$batter->idbatter}},
                    bats: '{{$batter->player->Bats}}',
                    number: {{$batter->Number}},
                    batter: {{$batter->BatterPosition}},
                    name: '{{$batter->player->getFullName()}}',
                    position: '{{Batter::$defensePositions[$batter->DefensePosition]}}'
                },
                @endforeach
                ],
            fielders: [
                @foreach ($lineupPlayers[1]['fielders'] as $batter)
                    {
                        id: {{$batter->idbatter}},
                        number: {{$batter->Number}},
                        name: '{{$batter->player->getFullName()}}',
                        position: '{{Batter::$defensePositions[$batter->DefensePosition]}}',
                        positionId: {{$batter->DefensePosition}}
                    },
                @endforeach
                ],
            pitchers: [
                @foreach ($lineupPlayers[1]['pitchers'] as $batter)
                {
                    id: {{$batter->idbatter}},
                    throws: '{{$batter->player->Throws}}',
                    number: {{$batter->Number}},
                    batter: {{$batter->BatterPosition}},
                    name: '{{$batter->player->getFullName()}}',
                    position: '{{Batter::$defensePositions[$batter->DefensePosition]}}'
                },
                @endforeach
            ],

            getPlayer: function(id, type){
                return _.find(this[type], function(b) {return b.id==id});
            }
        }
    };
</script>
@endif
<script>
    G.gameId = {{$game->idgame}};
    G.token = '{{csrf_token()}}';
    G.baseUrl = '{{URL::to('/')}}';
    G.gameStatus = {{$game->status}};
    G.isPitchTrackingEnabled = true;

    $.contextMenu( 'destroy', '.js-button-misc-context' );
    $.contextMenu({
        selector: '.js-button-misc-context',
        trigger: 'left',
        items:{
            start:{
                name: 'Start Game',
                callback: function(){
                    G.onUpdateGameStatus(1);
                }
            },
            end:{
                name: 'End Game',
                items:{
                    regulation:{
                        name: 'Regulation',
                        callback: function(){
                            G.onUpdateGameStatus(2);
                        }
                    },
                    extraInnings:{
                        name: 'Extra Innings',
                        callback: function(){
                            G.onUpdateGameStatus(3);
                        }
                    },
                    timeLimit:{
                        name: 'Time Limit',
                        callback: function(){
                            G.onUpdateGameStatus(4);
                        }
                    },
                    runRule:{
                        name: 'Run Rule',
                        callback: function(){
                            G.onUpdateGameStatus(5);
                        }
                    },
                    forfeit:{
                        name: 'Forfeit',
                        callback: function(){
                            G.onUpdateGameStatus(6);
                        }
                    },
                    darkness:{
                        name: 'Darkness',
                        callback: function(){
                            G.onUpdateGameStatus(7);
                        }
                    },
                    rainOut:{
                        name: 'Rain Out',
                        callback: function(){
                            G.onUpdateGameStatus(8);
                        }
                    },
                    other:{
                        name: 'Other',
                        callback: function(){
                            G.onUpdateGameStatus(9);
                        }
                    }
                }
            },
            close:{
                name: 'Close',
                callback: function(){
                    G.onRedirect('{{action('GameController@index')}}');
                }
            }//,

//            debug:{
//                name: 'Debug',
//                items:{
//                    getJson: {
//                        name: 'Get Storage Json',
//                        callback: function(item){
//                            G.onDebug(item);
//                        }
//                    },
//                    restore: {
//                        name: 'Restore',
//                        callback: function(item){
//                            G.onDebug(item);
//                        }
//                    }
//                }
//            }
        }
    });

    $('.ui-menu-element a').click(function(){
        G.onRedirect($(this).attr('href'));
        return false;
    });
</script>
</body>
</html>