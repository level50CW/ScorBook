<?php
/* @var $state 
		$visitingTeamTable
		$homeTeamTable
		$visitingRunsTable
		$homeRunsTable

*/

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

function renderTableRuns($runs, $form)
{
    $i=1;
    foreach($runs->runs as $field => $value)
    {
        if ($field == '_empty') {
            echo "<td></td>";
		} else {
            echo "<td style='border: 1px solid' class='white'>" . $form->textfield($runs->runsOrigin, $field.'[]', array(
                    'value' => $value,
                    "id" => "r".$i . $idteam,
                    "class" => "inputnumbersinning",
                    'readonly' => "true"
                )) . "</td>";
		}
        $i++;
    }
}

function renderTableTeam($form, $teamTable)
{
	$positions = array('P','C','1B','2B','3B','SS','LF','CF','RF','EF','DH','PH','PR','CR','EH','X');
	
    $name = $teamTable->name;

    echo "<tr class='blacktitle'> <td colspan=8>" . $name . " </td> </tr>";

    $Batters = $teamTable->battersOrigin;
	$count = count($Batters);
	
    echo "<tr class='greentr'>";
    echo "<td colspan=3 style='width: 30%'> Lineup </td> <td>AB</td> <td>H</td> <td>RBI</td> <td>BB</td> <td>SO</td>";
    echo "</tr>";

	//Render batters
    for ($i = 0; $i < $count; $i++) {
		
		if ($teamTable->batters[$i]->isPitcher) {
			continue;
		}

        $class = "grayatbat";
		if ($teamTable->batters[$i]->isSelected){
			$class = "brownatbat";
		}
				
		echo "<tr>
		<td colspan=3 class='$class'>" . $Batters[$i]->Number . " " . $teamTable->batters[$i]->player->Firstname . ' ' . $teamTable->batters[$i]->player->Lastname[0] . " - " . $positions[$Batters[$i]->DefensePosition - 1] . "</td>";
		
		foreach($teamTable->batters[$i]->Statshitting as $field => $value){
			echo "<td class='$class'>" . $form->textfield($teamTable->batters[$i]->StatshittingOrigin, $field.'[]', array(
					"readonly" => 'true',
					'value' => $value,
					'class' => 'inputnumbers',
					'maxsize' => 2,
					"id" => $positions[$Batters[$i]->DefensePosition - 1].$teamTable->batters[$i]->player->idplayer
				)) . "</td>";
		}

		echo "</tr>";
    }

	//Render pitcher
    echo "<tr class='trdiv'></tr>";
    echo "<tr>";
    echo "<td class='blacktitle' colspan=8> PITCHING STAT </td>";
    echo "</tr>";
    echo "<tr class='greentr'>";
    echo "<td width='30%'> Pitcher </td> <td>IP</td> <td>H</td> <td>R</td> <td>BB</td> <td>SO</td>  <td>B</td>  <td>S</td>";
    echo "</tr>";

    for ($o = 0; $o < count($teamTable->pitcherIndexes); $o++) {
        $class  = "grayatbat";
        $i      = $teamTable->pitcherIndexes[$o];

        echo "<tr>
				<td 	 class='$class'>" . $Batters[$i]->Number . " " . $teamTable->batters[$i]->player->Firstname . " " . $teamTable->batters[$i]->player->Lastname[0] . "</td>";

        foreach($teamTable->batters[$i]->Statspitching as $field => $value){
            echo "<td class='$class'>" . $form->textfield($teamTable->batters[$i]->StatspitchingOrigin, $field.'[]', array(
                    "readonly" => 'true',
                    'value' => $value,
                    'class' => 'inputnumbers',
                    'maxsize' => 2,
                    "id" => "p".$field.$teamTable->batters[$i]->player->idplayer
                )) . "</td>";
		}
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
    echo $form->errorSummary($model);
	
	
							//renderTableTeam($form, preLoadTableTeam($state->idlineupvisiting, $state));
    ?>

    <div class="tableHome">
	
        <table >
            <tr>
                <td class="tdUpper"> <p></p>
                    <table class="tablevisiting">
                        <?
                        if ($state->idlineupvisiting) {
							renderTableTeam($form, $visitingTeamTable);
						}
                        ?>
                    </table>

                    <table class="tablehome">
                        <?
                        if ($state->idlineuphome) {
							renderTableTeam($form, $homeTeamTable);
                        }
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
                                                        <? printLogo($state->battingteam )  ?>
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
                                            <td class='grayatbat'><?php echo $state->teamvisiting;?></td>
                                            <?
                                            renderTableRuns( $visitingRunsTable ,$form);
                                            ?>
                                        </tr>
                                        <tr>
                                            <td class='grayatbat'><?php echo $state->teamhome;?></td>
                                            <?
                                            renderTableRuns( $homeRunsTable ,$form);
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
        echo CHtml::hiddenField('link','',array('id'=>'link')); //bottom menu redirector
        ?>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>

<script src="js/AtBat/renderBaseballField.js" type="text/javascript"></script>

<? include "contextmenus.php"; ?>


