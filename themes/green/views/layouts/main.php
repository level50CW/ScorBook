<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/screen.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" media="print" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie.css" media="screen, projection" />
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/form.css" />

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<script>

    
function submitLink(link){
    if (link == 'atBat'){
        
        
    }
    
    
    switch(link)
    {
    case 'gamescreate':
        //document.getElementById('link').value = 'games/update';
        break;
    case 'atbata':
        document.getElementById('link').value = 'events/create';
        break;
    case 'atbat':

        var doWeBreakIt = false;

        var luh = <?php echo Yii::app()->user->getState('idlineuphome') ? 1 : 0; ?>;
        var luv = <?php echo Yii::app()->user->getState('idlineupvisiting') ? 1 : 0; ?>;

        if(!luh || !luv){
            alert("Lineups were not saved");
            return false;
        }
		
		var sizeHome = <?php echo Yii::app()->user->getState('batterHomeCount') ? Yii::app()->user->getState('batterHomeCount') : 0; ?>;		
		var sizeVisiting = <?php echo Yii::app()->user->getState('batterVisitingCount') ? Yii::app()->user->getState('batterVisitingCount') : 0; ?>;
		
        if(sizeHome < 9){
            alert("Add at least 9 Batters for Home team"); 
            return false;
        }
		
		if(sizeVisiting < 9){
            alert("Add at least 9 Batters for Visiting team"); 
            return false;
        }
		
        document.getElementById('link').value = 'events/create';
        break;
    case 'hlineup':
        if(<? echo Yii::app()->user->getState('idgame') > 0 ? 0 : 1 ?>){
            alert('Game is not selected.');
            return false;
        }
        document.getElementById('link').value = 'lineup/create&team=home';
        //document.getElementById('lineup-form').submit();
        break;
	case 'vlineup':
        if(<? echo Yii::app()->user->getState('idgame') > 0 ? 0 : 1 ?>){
            alert('Game is not selected.');
            return false;
        }
        document.getElementById('link').value = 'lineup/create&team=visiting';
        //document.getElementById('lineup-form').submit();
        break;
    case 'gameinfo':
        document.getElementById('link').value = 'scoreGame/update&id=<? echo Yii::app()->user->getState('idgame'); ?>';
        break;
    case 'games':
        document.getElementById('link').value = 'scoreGame/admin';
        break;
    case 'more':
        document.getElementById('link').value = 'more';
        break;
    case 'boxscore':
        document.getElementById('link').value = 'events/stats';
        
        break;
     case 'visitorscorecard':
        document.getElementById('link').value = 'events/scorecard&team=visit';
        
        break;
     case 'homescorecard':
        document.getElementById('link').value = 'events/scorecard&team=home';
        break;
     //Score screen
     case 'scorehome':
        document.getElementById('link').value = 'scorehome';
     break;
     
     case 'scorevisiting':
        document.getElementById('link').value = 'scorevisiting';
     break;
    
     case 'scoreseason':
        document.getElementById('link').value = 'scoreseason';
     break;
    
     case 'scoregame':
        document.getElementById('link').value = 'scoregame';
     break;

     case 'situation':
        document.getElementById('link').value = 'situation';
     break;
    
     case 'scorebatting':
        document.getElementById('link').value = 'scorebatting';
     break;
     
     case 'scorefielding':
        document.getElementById('link').value = 'scorefielding';
     break;
     
     case 'scorepitching':
     
        document.getElementById('link').value = 'scorepitching';
     break;
        
    default:
      ;
    }
    
    //document.forms[0].submit();
	if (window.form_onSubmit){
		if (window.form_onSubmit())
			$("form").first().submit();
	} else {
		$("form").first().submit();
	}
			
return  
}   

function finalizeGame(){
    window.location.href="index.php?r=games/finalize";
}
</script>

<body>

    <div class="container" id="page">
    
        <div id="header">
        <a href='./index.php'><div id="logo"><img src="Northwoods_League_logo.png"></div> </a>
    </div><!-- header -->

    <div id="mainmenu">
        <?php
        if(!Yii::app()->user->isGuest){
          echo "Welcome " .  Yii::app()->session['firstname'] . " " . Yii::app()->session['lastname'].'<br/>';
          echo "Last Login: " . Yii::app()->session['lastLoginTime'];
		}
        ?>
    </div><!-- mainmenu -->
    <div style="clear: both;"></div>
    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
        'links'=>$this->breadcrumbs,
    )); ?><!-- breadcrumbs -->


<!-- Begin of Menu   -->
        <?php
			$itemScheduleItems = array();
			$itemTeamsItems = array();
			$itemUsersItems = array();
			$itemSettingsItems = array();
			
			$itemScheduleItems[] = array('label'=>'Manage Games', 'url'=>array('schedule/admin'));
			
			$itemTeamsItems[] = array('label'=>'Manage Teams', 'url'=>array('teams/admin'));
			
			$itemUsersItems[] = array('label'=>'Manage Users', 'url'=>array('users/admin'));
			
			
			
			if (Yii::app()->session['role'] == 'admins' || Yii::app()->session['role'] == 'leagueadmin'){
				$itemScheduleItems[] = array('label'=>'Add New Game', 'url'=>array('schedule/update'));
				$itemScheduleItems[] = array('label'=>'Import Schedule', 'url'=>array('import/schedule'));
				$itemScheduleItems[] = array('label'=>'Export Schedule', 'url'=>array('principal/admin'), 'linkOptions'=>array('style'=>'color: #868686 !important;', 'onclick'=>'return false;'));
				
				$itemTeamsItems[] = array('label'=>'Add New Team', 'url'=>array('teams/create'));
				
				$itemSettingsItems[] = array('label'=>'General Settings', 'url'=>array('settings/change'), 'linkOptions'=>array('style'=>'width: 118px;'));
				$itemSettingsItems[] = array('label'=>'System Settings', 'url'=>array('principal/admin'), 'linkOptions'=>array('style'=>'color: #868686 !important;', 'onclick'=>'return false;'));
			}
			
			if (Yii::app()->session['role'] == 'admins' || Yii::app()->session['role'] == 'leagueadmin' || Yii::app()->session['role'] == 'teamadmin' ){
				$itemUsersItems[] = array('label'=>'Add New User', 'url'=>array('users/create'));
			}
			
			$itemSettingsItems[] = array(
								'label' => 'Logout',
								'url' => array('site/logout'),
								'linkOptions' => array(
									'onclick' => "if(!confirm('Are you sure you want to exit?')){ return false; };"));
		
			$itemSchedule = array('label'=>'Schedule', 
                            'submenuOptions'=>array('class'=>'nav-sub'),'items'=>$itemScheduleItems);
							
			$itemGameStatistics = array('label'=>'Game Statistics', 
                            'submenuOptions'=>array('class'=>'nav-sub'),'items'=>array(
                            array('label'=>'Edit Complete Game Stats', 'url'=>array('games/admin')),
                        ));
			$itemTeams = array('label'=>'Teams', 
                            'submenuOptions'=>array('class'=>'nav-sub'),'items'=>$itemTeamsItems);
							
			$itemRosters = array('label'=>'Rosters', 
                            'submenuOptions'=>array('class'=>'nav-sub'),'items'=>array(
                            array('label'=>'Manage Players', 'url'=>array('players/admin')),
                            array('label'=>'Add New Player', 'url'=>array('players/create')),
                            array('label'=>'Import Rosters', 'url'=>array('principal/admin'), 'linkOptions'=>array('style'=>'color: #868686 !important;', 'onclick'=>'return false;')),
                            array('label'=>'Export Rosters', 'url'=>array('principal/admin'), 'linkOptions'=>array('style'=>'color: #868686 !important;', 'onclick'=>'return false;')),
                        ));
			$itemLeagues = array('label'=>'Leagues', 
                            'submenuOptions'=>array('class'=>'nav-sub'),'items'=>array(
                            array('label'=>'Manage Leagues', 'url'=>array('league/admin')),
                            array('label'=>'Add New League', 'url'=>array('league/create')),
                            array('label'=>'Manage Divisions', 'url'=>array('division/admin')),
                            array('label'=>'Add New Division', 'url'=>array('division/create')),
                        ));
			$itemUsers = array('label'=>'Users', 
                            'submenuOptions'=>array('class'=>'nav-sub'),'items'=>$itemUsersItems);
							
			$itemSettings = array('label'=>'Settings',
                            'submenuOptions'=>array('class'=>'nav-sub'),'items'=>$itemSettingsItems);
							
			$itemScoreGame = array('label'=>'Score Game', 
                            'submenuOptions'=>array('class'=>'nav-sub'),'items'=>array(
                            array('label'=>'Todays Games', 'url'=>array('scoreGame/admin')),
                            array('label'=>'Scorecard', 'url'=>array('')),
                            array('label'=>'Complete Game', 'url'=>array('')),
                        ));
		
			$menu = null;
			// if ( Yii::app()->session['role']  == 'admins' || Yii::app()->session['role']  == 'leagueadmin' ){
				// $menu = array($itemSchedule, $itemGameStatistics, $itemTeams, $itemRosters, $itemLeagues, $itemUsers, $itemSettings);
			// } else if ( Yii::app()->session['role']  == 'scorer' ){
				// $menu = array($itemScoreGame, $itemSettings);
			// } else if(Yii::app()->session['role']  == 'roster' || Yii::app()->session['role']  == 'teamadmin'){
				// $menu = array($itemSchedule, $itemTeams, $itemRosters, $itemUsers, $itemSettings);
			// } else if ( Yii::app()->session['role']  == 'user' ){
				// $menu = array($itemSettings);
			//}
			
			if (isset($menu)){
				$this->widget('zii.widgets.CMenu', array(
                    'activeCssClass'=>'active',
                    'id'=>'navigation',

                    'items'=>$menu,
					'htmlOptions'=>array('class'=>'nav-main')));
			}

		
            // if ( Yii::app()->session['role']  == 'admins' ){

                // $this->widget('zii.widgets.CMenu', array(
                    // 'activeCssClass'=>'active',
                    // 'id'=>'navigation',

                    // 'items'=>array($itemSchedule, $itemGameStatistics, $itemTeams, $itemRosters, $itemLeagues, $itemUsers, $itemSettings),
					// 'htmlOptions'=>array('class'=>'nav-main')));

            // }else if ( Yii::app()->session['role']  == 'scorer' ){

                // $this->widget('zii.widgets.CMenu', array(
                    // 'activeCssClass'=>'active',
                    // 'id'=>'navigation',

                    // 'items'=>array(
                        

                        // array('label'=>'Schedule', 
                            // 'submenuOptions'=>array('class'=>'nav-sub'),'items'=>array(
                            // array('label'=>'Manage Games', 'url'=>array('schedule/admin')),
                        // )),

                        // array('label'=>'Score Game', 
                            // 'submenuOptions'=>array('class'=>'nav-sub'),'items'=>array(
                            // array('label'=>'Todays Games', 'url'=>array('scoreGame/admin')),
                        // )),
                        // array('label'=>'Settings',
                              // 'submenuOptions'=>array('class'=>'nav-sub'),
                              // 'items'=>array(
                                // array('label'=>'League', 'url'=>array('teams/admin')),
                                // array('label'=>'Logout', 'url'=>array('site/logout'), 'onclick'=>'if(!confirm("asdasd")){ return false; }'),
                        // )),
                    // ),
                    // 'htmlOptions'=>array('class'=>'nav-main'),
                // ));

            // }else if(Yii::app()->session['role']  == 'roster'){

                // $this->widget('zii.widgets.CMenu', array(
                    // 'activeCssClass'=>'active',
                    // 'id'=>'navigation',
                    // 'items'=>array(
                        // array('label'=>'Schedule', 
                            // 'submenuOptions'=>array('class'=>'nav-sub'),'items'=>array(
                            // array('label'=>'Manage Games', 'url'=>array('schedule/admin')),
                        // )),
                        // array('label'=>'Rosters', 
                            // 'submenuOptions'=>array('class'=>'nav-sub'),'items'=>array(
                            // array('label'=>'Manage Players', 'url'=>array('players/admin')),
                            // array('label'=>'Add New Player', 'url'=>array('players/create')),
                        // )),
                        // array('label'=>'Settings',
                              // 'submenuOptions'=>array('class'=>'nav-sub'),
                              // 'items'=>array(
                                // array('label'=>'League', 'url'=>array('teams/admin')),
                                // array(
                                    // 'label' => 'Logout',
                                    // 'url' => 'site/logout',
                                    // 'linkOptions' => array(
                                        // 'submit' => array('delete', 'id' => $model->id),
                                        // 'confirm' => 'Are you sure you want to delete this model?')
                                // ),
                                
                        // )),
                    // ),
                    // 'htmlOptions'=>array('class'=>'nav-main'),
                // ));
            // }

        ?>
    
    <!-- End of Menu -->


    <?php echo $content; ?>
    </div>
    
    <div id="footer" align="center">
    
        <?
        //Check if URL contains 
        $pos = strpos(Yii::app()->request->url, 'events');
        if (!$pos) $pos = strpos(Yii::app()->request->url, 'games/update');
        //if (!$pos) $pos = strpos(Yii::app()->request->url, 'schedule/update');
        if (!$pos) $pos = strpos(Yii::app()->request->url, 'scoreGame/update');
        if (!$pos) $pos = strpos(Yii::app()->request->url, 'games/finalize');
        if (!$pos) $pos = strpos(Yii::app()->request->url, 'schedule/finalize');
        if (!$pos) $pos = strpos(Yii::app()->request->url, 'scoreGame/finalize');
        //if (!$pos) $pos = strpos(Yii::app()->request->url, 'scoreGame/admin');
        if (!$pos) $pos = strpos(Yii::app()->request->url, 'lineup/create');
        //if (!$pos) $pos = strpos(Yii::app()->request->url, 'events/scorecard');
        
        /*var_dump($pos);
        var_dump(Yii::app()->user->name);
        var_dump(Yii::app()->user->getState('idgame'));
        var_dump(Yii::app()->user->getState('idteamhome'));*/
        
        ?>
        <? if (Yii::app()->user->name !="Guest" && $pos)  { ?>
        <div align="center">
            <table style='width:20% !important'>
            <tr>
				<td>
                    <?php //echo CHtml::Button('GAME INFO', array('onClick'=>'submitLink("gameinfo")')); ?>
                    <?php echo CHtml::image('images/button_bottom_gameinfo.png','',array('onClick'=>'submitLink("gameinfo")'));  ?>
                </td>
								
                <td>
                    <?php //echo CHtml::Button('VLINE UP', array('onClick'=>'submitLink("lineup")')); ?>
                    <?php echo CHtml::image('images/button_bottom_vlineup.png','',array('onClick'=>'submitLink("vlineup")'));  ?>
                </td>
				
                <td>
                    <?php //echo CHtml::Button('HLINE UP', array('onClick'=>'submitLink("lineup")')); ?>
                    <?php echo CHtml::image('images/button_bottom_hlineup.png','',array('onClick'=>'submitLink("hlineup")'));  ?>
                </td>
                
                <td>
                    <?php //echo CHtml::Button('AT BAT', array('onClick'=>'submitLink("atBat")')); ?>
                    <?php echo CHtml::image('images/button_bottom_atbat.png','',array('onClick'=>'submitLink("atbat")'));  ?>
                </td>

                <td>
                    <?php //echo CHtml::Button('BOX SCORE', array('disabled'=>'true','onClick'=>'submitLink("gameinfo")')); ?>
                    <?php echo CHtml::image('images/button_bottom_boxscore.png','',array('onClick'=>'submitLink("boxscore")'));  ?>
                </td>
				
                <td>
                    <?php //echo CHtml::Button('VISITORS', array('onClick'=>'submitLink("gameinfo")')); ?>
                    <?php echo CHtml::image('images/button_bottom_visitors.png','',array('onClick'=>'submitLink("visitorscorecard")'));  ?>
                </td>
                
                <td>
                    <?php //echo CHtml::Button('HOME TEAM', array('onClick'=>'submitLink("gameinfo")')); ?>
                    <?php echo CHtml::image('images/button_bottom_hometeam.png','',array('onClick'=>'submitLink("homescorecard")'));  ?>
                </td>
                
                
                <td>
                    <?php //echo CHtml::Button('BOX SCORE', array('disabled'=>'true','onClick'=>'submitLink("gameinfo")')); ?>
                    <?php echo CHtml::image('images/button_bottom_more.png','',array('id'=>'more'));  ?>
                </td>
                    <?php //MISC Functions
                    $this->widget('ext.jcontextmenu.JContextMenu', array(
                            'selector' => '#more',
                             'trigger' => 'left',
                            'ignoreRightClick' => true,
                            'callback' => 'js:function(key, options) {
                                var m = "clicked: " + key;
                                
                            
                        }', 
                                    
                           'items' => array(
                                        'complete' => array('name' => 'Complete This Game',),//'callback' => 'js:function(){ finalizeGame(); }'
                                       
                                        'back' => array('name' => 'Back to Todays Games',), //'icon'=>'quit'
                                    ),
                                )
                       
                     );
                    ?>  
            
            </tr>
            </table>
        </div>
     
        <? } ?>

		Copyright &copy; <?php echo date('Y'); ?>-<?php echo 1+date('Y'); ?> Northwoods League. All Rights Reserved.<br/><br/> 
        <hr style="width:200px; margin:0 auto;">
        <script>
            
        //Enable finalize Game
        //document.getElementById("more").id = 'moredisable';
        if (typeof(inning) != "undefined")
            if (inning ==9) document.getElementById('moredisable').id = 'more';
            
        </script>
    </div><!-- footer -->

</div><!-- page -->


<?php Yii::app()->clientScript->registerScript('menu','
$("ul.nav-main > li:has(ul)").on("click",function(event){ 
 event.stopPropagation();
 $(this).parent().find("li").css({"background-color":"#680102"}).find("ul").css({"display":"none"});
 $(this).css({"background-color":"#CCC"}).find("ul").css({"display":"block"});
});
$(document).on("click",function(){$(".nav-sub").css({"display":"none"}); $(".nav-main li").css({"background-color":"#680102"});});',CClientScript::POS_END); ?>



</body>
</html>