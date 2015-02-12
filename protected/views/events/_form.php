
<script>
    document.getElementById("content").style.width = "1100px";
    document.getElementById("page").style.width = "1100px";
</script>

<?php
$state = new stdClass;
$state->idgame = Yii::app()->user->getState('idgame');
$state->idteamhome = Yii::app()->user->getState('idteamhome');
$state->idteamvisiting = Yii::app()->user->getState('idteamvisiting');
$state->teamhome = Yii::app()->user->getState('teamhome');
$state->teamvisiting = Yii::app()->user->getState('teamvisiting');
$state->battingteam = Yii::app()->user->getState('battingteam');
$state->batterNumber = Yii::app()->user->getState('batterNumber');
$state->inning = Yii::app()->user->getState('inning');
$state->idlineuphome = Yii::app()->user->getState('idlineuphome');
$state->idlineupvisiting = Yii::app()->user->getState('idlineupvisiting');

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

function loadTableRuns($idgame, $idteam, $form)
{
    //Load runs
    $runsArray = Runs::getByGameTeam($idgame, $idteam);

    if (count($runsArray)) {
        $runs = $runsArray[0];
    }
    else
        $runs = new Runs;

    $stdRuns = new stdClass;
    $stdRuns->inning1 = $runs->inning1;
    $stdRuns->inning2 = $runs->inning2;
    $stdRuns->inning3 = $runs->inning3;
    $stdRuns->inning4 = $runs->inning4;
    $stdRuns->inning5 = $runs->inning5;
    $stdRuns->inning6 = $runs->inning6;
    $stdRuns->inning7 = $runs->inning7;
    $stdRuns->inning8 = $runs->inning8;
    $stdRuns->inning9 = $runs->inning9;
    $stdRuns->_empty = '';
    $stdRuns->R = $runs->R;
    $stdRuns->H = $runs->H;
    $stdRuns->E = $runs->E;

    $i=1;
    foreach($stdRuns as $field => $value)
    {
        if ($field == '_empty')
            echo "<td></td>";
        else
            echo "<td style='border: 1px solid' class='white'>" . $form->textfield($runs, $field.'[]', array(
                    'value' => $value,
                    "id" => "r".$i . $idteam,
                    "class" => "inputnumbersinning",
                    'readonly' => "true"
                )) . "</td>";
        $i++;
    }
}


function loadTableTeam($id, $form, $model, $state)
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

    $name = $state->idteamhome == $teamid ? $state->teamhome : $state->teamvisiting;

    if ($name)
        echo "<tr class='blacktitle'> <td colspan=8>" . $name . " </td> </tr>";
    else
        echo "<tr> <td colspan=4> LINEUP MUST BE CREATED </td> </tr>";

    //LOAD BATTERS
    $Batters = Batters::getByLineup($idLineup);

    $count = sizeof($Batters);

    $StatshittingArray = Statshitting::getByGame($state->idgame);
    $count_stats_hit   = count($StatshittingArray);

    $StatsfieldingArray = Statsfielding::getByGame($state->idgame);
    $count_stats_field  = count($StatsfieldingArray);

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
        if ($state->battingteam == $teamid) {
            //Style player at bat

            if ($state->batterNumber == $i + 2) {
                $class  = "brownatbat";
                $number = $i + 1;
            }
        } else {
            //Search the player stats
            $e = 0;
            $Statsfielding = new Statsfielding;
            for ($e; $e < $count_stats_field; $e++) {
                if ($StatsfieldingArray[$e]->Players_idplayer == $player->idplayer) {
                    $Statsfielding = $StatsfieldingArray[$e];
                    $e = $count_stats_field;
                }
            }
        }

        $e = 0;
        $Statshitting = new Statshitting;
        for ($e; $e < $count_stats_hit; $e++) {
            if ($StatshittingArray[$e]->Players_idplayer == $player->idplayer) {
                $Statshitting = $StatshittingArray[$e];
                $e = $count_stats_hit;
            }
        }

        if ($Batters[$i]->DefensePosition != "1") {

            echo "<tr>
			<td colspan=3 class='$class'>" . $Batters[$i]->Number . " " . $player->Firstname . ' ' . $player->Lastname[0] . " - " . $positions[$Batters[$i]->DefensePosition - 1] . "</td>";

            $stdStatshitting = new stdClass;
            $stdStatshitting->AB = $Statshitting->AB;
            $stdStatshitting->H = $Statshitting->H;
            $stdStatshitting->RBI = $Statshitting->RBI;
            $stdStatshitting->BB = $Statshitting->BB;
            $stdStatshitting->SO = $Statshitting->SO;
            $stdStatshitting->RBI = $Statshitting->RBI;

            foreach($stdStatshitting as $field => $value)
                echo "<td class='$class'>" . $form->textfield($Statshitting, $field.'[]', array(
                        "readonly" => 'true',
                        'value' => $value,
                        'class' => 'inputnumbers',
                        'maxsize' => 2,
                        "id" => "AB".$player->idplayer
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
    $StatspitchingArray = Statspitching::getByGame($state->idgame);
    $count_stats_pit = count($StatspitchingArray);

    for ($o = 0; $o < count($pitcher); $o++) {
        $class  = "grayatbat";
        $i      = $pitcher[$o];
        $player = Players::model()->findByPk($Batters[$i]->Players_idplayer); //CAMBIAR LIST de USUARIOS

        $e = 0;
        $Statspitching = new Statspitching;
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

        if ($state->inning == 1) {
            $Statspitching->GS = 1;
        } else
            $Statspitching->GS = 0;

        //The total number of games in which the pitcher appeared, whether as the starter or as a reliever.
        if (!$Statspitching->G)
            $Statspitching->G = 1;

        $stdStatspitching = new stdClass;
        $stdStatspitching->IP = $Statspitching->IP;
        $stdStatspitching->H = $Statspitching->H;
        $stdStatspitching->R = $Statspitching->R;
        $stdStatspitching->BB = $Statspitching->BB;
        $stdStatspitching->SO = $Statspitching->SO;
        $stdStatspitching->B = $Statspitching->B;
        $stdStatspitching->S = $Statspitching->S;

        foreach($stdStatspitching as $field => $value)
            echo "<td class='$class'>" . $form->textfield($Statspitching, $field.'[]', array(
                    "readonly" => 'true',
                    'value' => $value,
                    'class' => 'inputnumbers',
                    'maxsize' => 2,
                    "id" => "p".$field.$player->idplayer
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
    echo $form->errorSummary($model);
    ?>

    <div class="tableHome">
        <table >
            <tr>
                <td class="tdUpper"> <p></p>
                    <table class="tablevisiting">
                        <?
                        if ($state->idlineupvisiting)
                            loadTableTeam($state->idlineupvisiting, $form, $model, $state);
                        ?>
                    </table>

                    <table class="tablehome">
                        <?
                        if ($state->idlineuphome) {
                            loadTableTeam($state->idlineuphome, $form, $model, $state);
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
                                            loadTableRuns ($state->idgame,$state->idteamvisiting,$form);
                                            ?>
                                        </tr>
                                        <tr>
                                            <td class='grayatbat'><?php echo $state->teamhome;?></td>
                                            <?
                                            loadTableRuns ($state->idgame,$state->idteamhome,$form);
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

</script>

<? include "contextmenus.php"; ?>


