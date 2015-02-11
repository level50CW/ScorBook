
<script>
	document.getElementById("content").style.width = "1100px";
	document.getElementById("page").style.width = "1100px";
</script>

<?php
function printLogo($id)
{
    $team = Teams::model()->findByPk($id);
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false) {
        // User agent is Google Chrome
        $position = 'top: 25px; right: 50px;';
    } else
        $position = 'top: -100px;';    
    if ($team->thumb) {
        echo "<img  style='position: relative; $position' src='images/thumbs/$team->thumb'/> </img>";
    }
}



/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */

$idgame = Yii::app()->user->getState('idgame');

function loadTableRuns($idgame, $idteam, $form)
{
    //Load runs
    $runsArray = Runs::getByGameTeam($idgame, $idteam);
    
    if (count($runsArray)) {
        $runs = $runsArray[0];
        //echo "<script> alert('yes'); </script>";
    }
	
	$scores = array(
		$runs->inning1,
		$runs->inning2,
		$runs->inning3,
		$runs->inning4,
		$runs->inning5,
		$runs->inning6,
		$runs->inning7,
		$runs->inning8,
		$runs->inning9,
		);
    
	for($i=0; $i<9; $i++)
		echo "<td style='border: 1px solid' class='white'>" . $form->textfield($runs, 'inning'.($i+1).'[]', array(
			'value' => $scores[$i],
			"id" => "r".($i+1) . $idteam,
			"class" => "inputnumbersinning",
			'readonly' => "true"
		)) . "</td>";
	    
    
    echo "<td></td>";
    echo "<td style='border: 1px solid' class='white'>" . $form->textfield($runs, 'R[]', array(
        'value' => $runs->R,
        "id" => "r11" . $idteam,
        "class" => "inputnumbersinning",
        'readonly' => "true"
    )) . "</td>";
    echo "<td style='border: 1px solid' class='white'>" . $form->textfield($runs, 'H[]', array(
        'value' => $runs->H,
        "id" => "r12" . $idteam,
        "class" => "inputnumbersinning",
        'readonly' => "true"
    )) . "</td>";
    echo "<td style='border: 1px solid' class='white'>" . $form->textfield($runs, 'E[]', array(
        'value' => $runs->E,
        "id" => "r13" . $idteam,
        "class" => "inputnumbersinning",
        'readonly' => "true"
    )) . "</td>";
    
}


function loadTableTeam($id, $form, $model)
{
    
    $positions = array(
        'P',
        'C',
        '1B',
        '2B',
        '3B',
        'SS',
        'LF',
        'CF',
        'RF',
        'EF',
        'DH',
        'PH',
        'PR',
        'CR',
        'EH',
        'X'
    );
    
    //LOAD LINEUP
    
    if (!$id)
        $id = 0;
    
    $idLineup = $id;
    $lineup   = Lineup::getById($idLineup);
    
    
    //LOAD TEAM INFO
    if (!$teamid = $lineup[0]->Teams_idteam)
        $teamid = 0;
    
	$name = Yii::app()->user->getState('idteamhome') == $teamid ? Yii::app()->user->getState('teamhome') : Yii::app()->user->getState('teamvisiting');
	
    if ($name)
        echo "<tr class='blacktitle'> <td colspan=8>" . $name . " </td> </tr>";
    else
        echo "<tr> <td colspan=4> LINEUP MUST BE CREATED </td> </tr>";
    
    //LOAD BATTERS
    $Batters = Batters::getByLineup($idLineup);
    
    $count = sizeof($Batters);
    
    //Load stats of players Hitting
    $idgame = Yii::app()->user->getState('idgame');
    
    $StatshittingArray = Statshitting::getByGame($idgame);
    $count_stats_hit   = count($StatshittingArray);
    
    $StatsfieldingArray = Statsfielding::getByGame($idgame);
    $count_stats_field  = count($StatsfieldingArray);
    
    //echo Yii::trace(CVarDumper::dumpAsString($rows),'varsearch');
    echo "<tr class='greentr'>";
    echo "<td colspan=3 style='width: 30%'> Lineup </td> <td>AB</td> <td>H</td> <td>RBI</td> <td>BB</td> <td>SO</td>";
    echo "</tr>";
    
    $pitcher = array();
    for ($i = 0; $i < $count; $i++) {
        
        $class = "grayatbat";
        
        //Select Pitcher || $Batters[$i]->DefensePosition == "11"
        if ($Batters[$i]->DefensePosition == "1") {
            $pitcher[] = $i;
        }
        
        $player = Players::model()->findByPk($Batters[$i]->Players_idplayer); //CAMBIAR LIST de USUARIOS
 
        //Player at Bat
        if (Yii::app()->user->getState('battingteam') == $teamid) {
            //Style player at bat
            
            if (Yii::app()->user->getState('batterNumber') == $i + 2) {
                $class  = "brownatbat";
                $number = $i + 1;
			}
        } else { //SELECT THE FIELD PLAYERS
            
            //Search the player stats
            $e = 0;
            if ($count_stats_field) {
                for ($e; $e < $count_stats_field; $e++) {
                    if ($StatsfieldingArray[$e]->Players_idplayer == $player->idplayer) {
                        $Statsfielding = $StatsfieldingArray[$e];
                        $e = $count_stats_field;
                    }
                }
            }
            
            if (!$Statsfielding->TC)
                $Statsfielding->TC = 0;
            if (!$Statsfielding->PO)
                $Statsfielding->PO = 0;
            if (!$Statsfielding->A)
                $Statsfielding->A = 0;
            if (!$Statsfielding->PB)
                $Statsfielding->PB = 0;
            
            
            if (!$Statsfielding->E)
                $Statsfielding->E = 0;
            if (!$Statsfielding->INN)
                $Statsfielding->INN = 0;
            if (!$Statsfielding->CS)
                $Statsfielding->CS = 0;
            if (!$Statsfielding->C_WP)
                $Statsfielding->C_WP = 0;
                        
        }
        
        
        $e = 0;
        
        //Search the player stats
        if ($count_stats_hit) {
            for ($e; $e < $count_stats_hit; $e++) {
                if ($StatshittingArray[$e]->Players_idplayer == $player->idplayer) {
                    $Statshitting = $StatshittingArray[$e];
                    $e = $count_stats_hit;
                }
            }
        }
        
        if ($Batters[$i]->DefensePosition != "1") {
            
            echo "<tr>
			<td colspan=3 class='$class'>" . $Batters[$i]->Number . " " . $player->Firstname . ' ' . $player->Lastname[0] . " - " . $positions[$Batters[$i]->DefensePosition - 1] . "</td>";
            
            if (!$Statshitting->AB)
                $Statshitting->AB = 0;
            if (!$Statshitting->H)
                $Statshitting->H = 0;
            if (!$Statshitting->RBI)
                $Statshitting->RBI = 0;
            if (!$Statshitting->BB)
                $Statshitting->BB = 0;
            if (!$Statshitting->SO)
                $Statshitting->SO = 0;
            
            if (!$Statshitting->PA)
                $Statshitting->PA = 0;
            if (!$Statshitting->R)
                $Statshitting->R = 0;
            if (!$Statshitting->v2B)
                $Statshitting->v2B = 0;
            if (!$Statshitting->v3B)
                $Statshitting->v3B = 0;
            if (!$Statshitting->HR)
                $Statshitting->HR = 0;
            if (!$Statshitting->TB)
                $Statshitting->TB = 0;
            if (!$Statshitting->IBB)
                $Statshitting->IBB = 0;
            if (!$Statshitting->HP)
                $Statshitting->HP = 0;
            if (!$Statshitting->SH)
                $Statshitting->SH = 0;
            if (!$Statshitting->SF)
                $Statshitting->SF = 0;
            if (!$Statshitting->SB)
                $Statshitting->SB = 0;
            if (!$Statshitting->CS)
                $Statshitting->CS = 0;
            if (!$Statshitting->LOB)
                $Statshitting->LOB = 0;
            if (!$Statshitting->OE)
                $Statshitting->OE = 0;
            if (!$Statshitting->FC)
                $Statshitting->FC = 0;
            if (!$Statshitting->CO)
                $Statshitting->CO = 0;
            if (!$Statshitting->DP)
                $Statshitting->DP = 0;
            if (!$Statshitting->TP)
                $Statshitting->TP = 0;
            if (!$Statshitting->OBP)
                $Statshitting->OBP = 0;
            if (!$Statshitting->SLG)
                $Statshitting->SLG = 0;
            if (!$Statshitting->AVG)
                $Statshitting->AVG = 0;
            
            echo "<td class='$class'>" . $form->textfield($Statshitting, 'AB[]', array(
                "readonly" => 'true',
                'value' => $Statshitting->AB,
                'class' => 'inputnumbers',
                'maxsize' => 2,
                "id" => "AB$player->idplayer"
            )) . "</td>";
            echo "<td class='$class'>" . $form->textfield($Statshitting, 'H[]', array(
                "readonly" => 'true',
                'value' => $Statshitting->H,
                'class' => 'inputnumbers',
                'maxsize' => 2,
                "id" => "H$player->idplayer"
            )) . "</td>";
            echo "<td class='$class'>" . $form->textfield($Statshitting, 'RBI[]', array(
                "readonly" => 'true',
                'value' => $Statshitting->RBI,
                'class' => 'inputnumbers',
                'maxsize' => 2,
                "id" => "RBI$player->idplayer"
            )) . "</td>";
            echo "<td class='$class'>" . $form->textfield($Statshitting, 'BB[]', array(
                "readonly" => 'true',
                'value' => $Statshitting->BB,
                'class' => 'inputnumbers',
                'maxsize' => 2,
                "id" => "BB$player->idplayer"
            )) . "</td>";
            echo "<td class='$class'>" . $form->textfield($Statshitting, 'SO[]', array(
                "readonly" => 'true',
                'value' => $Statshitting->SO,
                'class' => 'inputnumbers',
                'maxsize' => 2,
                "id" => "SO$player->idplayer"
            )) . "</td>";
            
            echo "</tr>";
        }
    }
    
    echo "<tr class='trdiv'></tr>";
    echo "<tr>";
    echo "<td class='blacktitle' colspan=8> PITCHING STAT </td>";
    echo "</tr>";
    echo "<tr class='greentr'>";
    echo "<td width='30%'> Pitcher </td> <td>IP</td> <td>H</td> <td>R</td> <td>BB</td> <td>SO</td>  <td>B</td>  <td>S</td>";
    echo "</tr>";
    
    //Load stats of players
    $StatspitchingArray = Statspitching::getByGame($idgame);    
    $count_stats_pit = count($StatspitchingArray);
    
    for ($o = 0; $o < count($pitcher); $o++) {
        $class  = "grayatbat";
        $i      = $pitcher[$o];
        $player = Players::model()->findByPk($Batters[$i]->Players_idplayer); //CAMBIAR LIST de USUARIOS
        
        $e = 0;
        //Search the pitcher stats
        if ($count_stats_pit) {
            for ($e; $e < $count_stats_pit; $e++) {
                if ($StatspitchingArray[$e]->Players_idplayer == $player->idplayer) {
                    $Statspitching = $StatspitchingArray[$e];
                    $e = $count_stats_pit;
                }
            }
        }
		
        echo "<tr>
				<td 	 class='$class'>" . $Batters[$i]->Number . " " . $player->Firstname . " " . $player->Lastname[0] . "</td>";
        
        
        //Games started as the pitcher
        
        if (Yii::app()->user->getState('inning') == 1) {
            $Statspitching->GS = 1;
        } else
            $Statspitching->GS = 0;
        
        //The total number of games in which the pitcher appeared, whether as the starter or as a reliever.
        if (!$Statspitching->G)
            $Statspitching->G = 1;
        
        
        echo "<td class='$class'>" . $form->textfield($Statspitching, 'IP[]', array(
            "readonly" => 'true',
            'value' => $Statspitching->IP,
            'class' => 'inputnumbers',
            'maxsize' => 2,
            "id" => "pIP$player->idplayer"
        )) . "</td>";
        echo "<td class='$class'>" . $form->textfield($Statspitching, 'H[]', array(
            "readonly" => 'true',
            'value' => $Statspitching->H,
            'class' => 'inputnumbers',
            'maxsize' => 2,
            "id" => "pH$player->idplayer"
        )) . "</td>";
        echo "<td class='$class'>" . $form->textfield($Statspitching, 'R[]', array(
            "readonly" => 'true',
            'value' => $Statspitching->R,
            'class' => 'inputnumbers',
            'maxsize' => 2,
            "id" => "pR$player->idplayer"
        )) . "</td>";
        echo "<td class='$class'>" . $form->textfield($Statspitching, 'BB[]', array(
            "readonly" => 'true',
            'value' => $Statspitching->BB,
            'class' => 'inputnumbers',
            'maxsize' => 2,
            "id" => "pBB$player->idplayer"
        )) . "</td>";
        echo "<td class='$class'>" . $form->textfield($Statspitching, 'SO[]', array(
            "readonly" => 'true',
            'value' => $Statspitching->SO,
            'class' => 'inputnumbers',
            'maxsize' => 2,
            "id" => "pSO$player->idplayer"
        )) . "</td>";
        echo "<td class='$class'>" . $form->textfield($Statspitching, 'B[]', array(
            "readonly" => 'true',
            'value' => $Statspitching->B,
            'class' => 'inputnumbers',
            'maxsize' => 2,
            "id" => "pB$player->idplayer"
        )) . "</td>";
        echo "<td class='$class'>" . $form->textfield($Statspitching, 'S[]', array(
            "readonly" => 'true',
            'value' => $Statspitching->S,
            'class' => 'inputnumbers',
            'maxsize' => 2,
            "id" => "pS$player->idplayer"
        )) . "</td>";
        
        echo "</tr>";
        
    }
    
    echo "</tr>";
    
}

?>

<div class="form">

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'events-form',
    'enableAjaxValidation' => false
));
?>
	<?php
echo $form->errorSummary($model);
?>
	
	<div class="tableHome">
	
	<table >
		
		<tr>
			
			<td class="tdUpper"> <p></p>
			<table class="tablevisiting">
				
				<?

$gameid = Yii::app()->user->getState('idgame');


$idteam   = Yii::app()->user->getState('idteamvisiting');
$lineup = Lineup::getByGameTeam($gameid, $idteam);

Yii::app()->user->setState('idlineupvisiting', $lineup[0]['idlineup']);

if (!Yii::app()->user->getState('idlineupvisiting'))
    Yii::app()->user->setState('idlineupvisiting', 0);


loadTableTeam(Yii::app()->user->getState('idlineupvisiting'), $form, $model);
?>


			</table>
	
			<table class="tablehome">
				<?


if (!Yii::app()->user->getState('idlineuphome')) {
    $idteam = Yii::app()->user->getState('idteamhome');
    $lineup = Lineup::getByGameTeam($gameid, $idteam);
    Yii::app()->user->setState('idlineuphome', $lineup[0]['idlineup']);
}

loadTableTeam(Yii::app()->user->getState('idlineuphome'), $form, $model);
?>
				
				
				
			</table>
				
		
				
			</td>
			
			<td style="padding-left: 10px;">	
				<div class="comments">
				
				<table>
					<tr>
					<td class='darkgreentr'>
						<?php echo "At Bat History"; ?>
					</td>
					<td class='darkgreentr'>
						<?php echo "Comments"; ?>
					</tr>
					
					<tr class='greentr'>
						<td ><?php echo $form->textarea($model,'Comment'); ?>
						<?php echo $form->error($model,'comments'); ?>
						</td> 
						<td><?php echo $form->textarea($model,'Comment'); ?>
						<?php echo $form->error($model,'comments'); ?></td>
					</tr>
					<tr>
						<td colspan="2">
							<div>
							<div class="HR">
							
							</div>
							
							<table >
								<tr>
									
									<td colspan=8 style="text-align: left" >
									<canvas id="myDrawing" width="510" height="400" disabled="true"  >
										
									<!-- style="background-image:url('images/field.png'); background-repeat: no-repeat; background-position:center" -->
									<p>Your browser doesn't support canvas.</p>
									</canvas>	
									<br>
									
									</td> 
									<td width="5%" style="margin-bottom: 0px; vertical-align: bottom">
										<table style="margin-bottom: 0px; vertical-align: bottom">
											<tr></tr><td id=HR> <?php echo CHtml::image('images/button_hr.png','',array('id'=>'buttonHR',"onClick"=>'fillhr(1)')); ?> </td> </tr>
											<tr></tr><td id=3B> <?php echo CHtml::image('images/button_3b.png','',array('id'=>'button3B',"onClick"=>'fill3b(1)')); ?> </td> </tr>
											<tr></tr><td id=2B> <?php echo CHtml::image('images/button_2b.png','',array('id'=>'button2B',"onClick"=>'fill2b(1)')); ?> </td> </tr>
											<tr></tr><td id=1B> <?php echo CHtml::image('images/button_1b.png','',array('id'=>'button1B',"onClick"=>'fill1b(1)')); ?> </td> </tr>
											<tr></tr><td id=BB> <?php echo CHtml::image('images/button_bb.png','',array('id'=>'buttonBB',"onClick"=>'fillbb(1)')); ?></td> </tr>
											<tr></tr><td id=HP> <?php echo CHtml::image('images/button_hp.png','',array('id'=>'buttonHP',"onClick"=>'fillhp(1)')); ?> </td> </tr>
											<tr></tr><td id=balltrayectory> <?php echo CHtml::image('images/button_balltray.png','',array('id'=>'balltray',"onClick"=>'enableBallTray()')); ?> </td> </tr>
											<tr></tr><td id=*> <?php echo CHtml::image('images/button_defense.png','',array('id'=>'defense',"onClick"=>'defenseLineup()')); ?> </td> </tr>
										</table>
										
									</td>
								</tr>
								<tr style="text-align: right;">
									<td style="text-align: left;height: 20px;" class="logo" rowspan="4">
										<div style='height:10px;'>
											<? printLogo(Yii::app()->user->getState('battingteam') )  ?>  
										</div>  
										
									</td>
									<td class="logo"> </td>
									<td width=5% style='white-space: nowrap;'><?php echo CHtml::image('images/button_k.png','',array('id'=>'K')); ?></td>
									<td width=5% style='white-space: nowrap;'><?php echo CHtml::image('images/button_fc.png','',array('id'=>'FC')); ?></td>
									<td width=5% style='white-space: nowrap;'><?php echo CHtml::image('images/button_dp.png','',array('id'=>'DP')); ?></td>
									<td width=5% style='white-space: nowrap;'><?php echo CHtml::image('images/button_sac.png','',array('id'=>'SAC')); ?></td>
									<td width=5% style='white-space: nowrap;'><?php echo CHtml::image('images/button_misc.png','',array('id'=>'Misc')); ?></td>
									<td width=5% style='white-space: nowrap;'><?php echo CHtml::image('images/button_batter.png','',array('id'=>'batter')); ?></td>
									<td width=5% style='white-space: nowrap; margin: -10px !important'><?php echo CHtml::image('images/button_nextbatter.png','',array('id'=>'nextbatter')); ?></td>
									
								</tr>
																		
							</table>
					
							<table class="FoulBalls">
								<tr >
									<td style="border: 1px solid;width:20px; border-color: #999999;"><?php echo CHtml::button(' ', array('onclick' => "fillball('6',1)",'style'=>'border:0px;','class'=>'B4_gray',"id"=>"ball6Button",'disabled'=>true)); ?></td>
									<td style="border: 1px solid;width:20px; border-color: #999999;"><?php echo CHtml::button(' ', array('onclick' => "fillball('4',1)",'style'=>'border:0px;','class'=>'B4',"id"=>"ball4Button")); ?></td>
									<td style="border: 1px solid;width:20px; border-color: #999999;"><?php echo CHtml::button(' ', array('onclick' => "fillball('5',1)",'style'=>'border:0px;','class'=>'B4',"id"=>"ball5Button")); ?></td>
								</tr>
								<tr>
									<td style="border: 1px solid;width:20px; border-color: #999999;"><?php echo CHtml::button(' ', array('onclick' => "fillball('1',1)",'style'=>'border:0px;','class'=>'B4',"id"=>"ball1Button")); ?></td>
									<td style="border: 1px solid;width:20px; border-color: #999999;"><?php echo CHtml::button(' ', array('onclick' => "fillball('2',1)",'style'=>'border:0px;','class'=>'B4',"id"=>"ball2Button")); ?></td>
									<td style="border: 1px solid;width:20px; border-color: #999999;"><?php echo CHtml::button(' ', array('onclick' => "fillball('3',1)",'style'=>'border:0px;','class'=>'B4',"id"=>"ball3Button")); ?></td>
								</tr>
								
							</table>
						</td>
					</tr>
					<tr>
						
						<td colspan="2">
							<table style="margin-bottom: 0em">
								<tr class="blacktitle">
									<td></td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td></td><td>R</td><td>H</td><td>E</td>
								</tr>
								
								<tr>
									<td class='grayatbat'><?php echo Yii::app()->user->getState('teamvisiting');?></td>
									<?
									loadTableRuns ($idgame,Yii::app()->user->getState('idteamvisiting'),$form);
									?>
								</tr>
								
								<tr>
									<td class='grayatbat'><?php echo Yii::app()->user->getState('teamhome');?></td>
									
									<?
									loadTableRuns ($idgame,Yii::app()->user->getState('idteamhome'),$form);
									?>
								</tr>
								<tr>
									<td colspan="18">
											<?php echo CHtml::button('1', array('onclick' => "clickPos1(1)",'class'=>'f1')); ?>
											<?php echo CHtml::button('2', array('onclick' => "clickPos2(1)",'class'=>'f2')); ?>
											<?php echo CHtml::button('3', array('onclick' => "clickPos3(1)",'class'=>'f3')); ?>
											<?php echo CHtml::button('4', array('onclick' => "clickPos4(1)",'class'=>'f4')); ?>
											<?php echo CHtml::button('5', array('onclick' => "clickPos5(1)",'class'=>'f5')); ?>
											<?php echo CHtml::button('6', array('onclick' => "clickPos6(1)",'class'=>'f6')); ?>
											<?php echo CHtml::button('7', array('onclick' => "clickPos7(1)",'class'=>'f7')); ?>
											<?php echo CHtml::button('8', array('onclick' => "clickPos8(1)",'class'=>'f8')); ?>
											<?php echo CHtml::button('9', array('onclick' => "clickPos9(1)",'class'=>'f9')); ?>
											<?php echo CHtml::button('', array('onclick' => "RBItext()",'class'=>'RBI',"id"=>"RBI","value"=>'RBI')); ?>
											<?php echo CHtml::button('', array('onclick' => "ERtext()",'class'=>'ER',"id"=>"ER", "value"=>"ER")); ?>
											<?php echo CHtml::button('', array('class'=>'T1',"id"=>"T1")); ?>
											<?php echo CHtml::textfield('B1text','', array('onclick' => "B1text()",'class'=>'B1',"id"=>"B1")); ?>
											<?php echo CHtml::textfield('B2text','', array('onclick' => "B2text()",'class'=>'B2',"id"=>"B2")); ?>
											<?php echo CHtml::textfield('B3text','', array('onclick' => "B3text()",'class'=>'B3',"id"=>"B3")); ?>
											<?php echo CHtml::textfield('B4text','', array('onclick' => "B4text()",'class'=>'iB4',"id"=>"B4")); ?>
											<?php echo CHtml::button('', array('class'=>'OutNumber',"id"=>"OutNumber", "value"=>(isset($Outs) ? $Outs : 0)+1)); ?>
											<?php echo CHtml::textfield('OutText','', array('onclick' => "Outtext()",'class'=>'OutText',"id"=>"OutText")); ?>
											<?php echo CHtml::button('', array('class'=>'base1button',"id"=>"base1button")); ?>
											<?php echo CHtml::button('', array('class'=>'base2button',"id"=>"base2button")); ?>
											<?php echo CHtml::button('', array('class'=>'base3button',"id"=>"base3button")); ?>
											<?php echo CHtml::button('', array('class'=>'base4button',"id"=>"base4button")); ?>
											
									</td>
									
								</tr>
							</table>
						</td>
					</tr>
				</table>		
					
				</div>
			</td>
		</tr>
		
	</table>
	
<?
echo CHtml::hiddenField('link','',array('id'=>'link'));
?>

<?php $this->endWidget(); ?>

</div><!-- form -->

</div>

<script>
	
var drawingCanvas = document.getElementById('myDrawing');


// Check the element is in the DOM and the browser supports canvas
if(drawingCanvas.getContext) {
// Initaliase a 2-dimensional drawing context
	var basecanvas = drawingCanvas.getContext('2d');
//Canvas commands go here
}

basecanvas.beginPath();

function printBases(){
	basecanvas.save();
	basecanvas.restore();
	
	// Create the yellow face
	basecanvas.strokeStyle = "#FFFFFF";
	basecanvas.fillStyle = "#FFFFFF";
	
	//1B
	basecanvas.beginPath();
	basecanvas.moveTo(345,180);
	basecanvas.lineTo(355,185); // \
	basecanvas.lineTo(365,180); //  /
	basecanvas.lineTo(355,175); //  \
	basecanvas.lineTo(345,180); // /
	basecanvas.stroke();
	
	//2B
	basecanvas.beginPath();
	basecanvas.moveTo(242,152);
	basecanvas.lineTo(252,157); // \
	basecanvas.lineTo(262,152); //  /
	basecanvas.lineTo(252,147); //  \
	basecanvas.lineTo(242,152); // /
	basecanvas.stroke();
	
	//3B
	basecanvas.beginPath();
	basecanvas.moveTo(140,180);
	basecanvas.lineTo(150,185); // \
	basecanvas.lineTo(160,180); //  /
	basecanvas.lineTo(150,175); //  \
	basecanvas.lineTo(140,180); // /
	basecanvas.stroke();
	
	//PLATE
	basecanvas.beginPath();
	basecanvas.moveTo(242,230);
	basecanvas.lineTo(252,235); // \
	basecanvas.lineTo(262,230); //  /
	basecanvas.lineTo(262,225); // |
	basecanvas.lineTo(242,225); // |
	basecanvas.lineTo(242,230); // 
	basecanvas.stroke();
	
	basecanvas.save();
}

</script>

<?php 

 //$str1=loadEvents(1300);

if (!empty($str1)) {
	echo Yii::trace(CVarDumper::dumpAsString($str1), 'salida');
}
 
$str = "<script>
basecanvas.beginPath();
var imageObj = new Image();
imageObj.onload = function() {
	basecanvas.drawImage(imageObj, -2, 85);
	printBases();
	}
imageObj.src = 'images/Field.png';
basecanvas.stroke();
basecanvas.closePath();
basecanvas.beginPath();
basecanvas.globalCompositeOperation = 'source-over';


</script>";

echo $str;
?>

<? include "contextmenus.php"; ?>


