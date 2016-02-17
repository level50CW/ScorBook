<div class="ui-menu">
    <div class="ui-menu-element">
        <a href="{{action('GameController@edit',$game->idgame)}}">
            <img src="{{url('/images/menu/button_bottom_gameinfo.png')}}" alt="Game Info"/>
        </a>
    </div>
    <div class="ui-menu-element">
        <a href="{{action('LineupController@edit',['id'=>$game->idgame, 'team'=>'visitor'])}}">
            <img src="{{url('/images/menu/button_bottom_vlineup.png')}}" alt="Visitor Lineup"/>
        </a>
    </div>
    <div class="ui-menu-element">
        <a href="{{action('LineupController@edit',['id'=>$game->idgame, 'team'=>'home'])}}">
            <img src="{{url('/images/menu/button_bottom_hlineup.png')}}" alt="Home Lineup"/>
        </a>
    </div>
    <div class="ui-menu-element">
        <a href="{{action('AtBatController@index',$game->idgame)}}">
            <img src="{{url('/images/menu/button_bottom_atbat.png')}}" alt="At Bat"/>
        </a>
    </div>
    <div class="ui-menu-element">
        <a href="{{action('StatisticController@stats',[$game->idgame, 'home', 'game', 'batting'])}}">
            <img src="{{url('/images/menu/button_bottom_statistics.png')}}" alt="Statistics"/>
        </a>
    </div>
    <div class="ui-menu-element">
        <a href="{{action('ScorePadController@index',['id'=>$game->idgame, 'team'=>'visitor'])}}">
            <img src="{{url('/images/menu/button_bottom_visitors.png')}}" alt="Visitor ScorePad"/>
        </a>
    </div>
    <div class="ui-menu-element">
        <a href="{{action('ScorePadController@index',['id'=>$game->idgame, 'team'=>'home'])}}">
            <img src="{{url('/images/menu/button_bottom_hometeam.png')}}" alt="Home ScorePad"/>
        </a>
    </div>
    <div class="js-button-misc-context ui-menu-element" style="cursor: pointer">
        <img src="{{url('/images/menu/button_bottom_more.png')}}" alt="Misc" style="width: 120px;height: 71px;"/>
    </div>
</div>

@include('ui.jquery-context')

<script>
    $.contextMenu({
        selector: '.js-button-misc-context',
        trigger: 'left',
        items:{
            close:{
                name: 'Close',
                callback: function(){
                    window.location = '{{action('GameController@index')}}';
                }
            }
        }
    });

    $('.js-button-misc').click(function(){
        return false;
    });
</script>