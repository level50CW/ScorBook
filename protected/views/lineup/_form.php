<?php
/* @var $this LineupController */
/* @var $model Lineup */
/* @var $form CActiveForm */
?>


    <? //LOAD LINEUP
    
    $criteria = new CDbCriteria();
    $criteria->addcondition("Games_idgame=$model->Games_idgame AND Teams_idteam=$model->Teams_idteam");
    
    $lineup = new Lineup;
    $lineup = Lineup::model()->findAll($criteria);
    //$idlineup = $lineup->idlineup
    
    if (@$lineup[0]->idlineup) $model->idlineup = $lineup[0]->idlineup;
    
    /* $Player = new Players;
    $Players = CHtml::listData(Players::model()->findAll($criteria),'idplayer','Firstname');
    $Batters = new Batters; ?>
       */    
    echo Yii::trace(CVarDumper::dumpAsString($model->idlineup),'idlineup');

    /**
        Get Opponent Batters count
    **/

    $opponentTeam = $homeTeamID == $model->Teams_idteam ? $visitingTeamID : $homeTeamID;

    $criteria = new CDbCriteria();
    $criteria->addcondition("Games_idgame=$model->Games_idgame AND Teams_idteam=$opponentTeam");

    $opponentLineup = Lineup::model()->findAll($criteria);
    $opponentLineup = (!empty($opponentLineup) && $opponentLineup[0]->idlineup) ? $opponentLineup[0]->idlineup : null;
    
    if($opponentLineup){
        $opponentBattersStored = array();
        $criteria = new CDbCriteria();
        $criteria->addcondition("Lineup_idlineup = $opponentLineup");

        $opponentBattersStored = new Batters;
        $opponentBattersStored = Batters::model()->findAll($criteria);

        $opponentBattersCount = sizeof($opponentBattersStored);

        Yii::app()->clientScript->registerScript('opponentBC','var opponentBC = '.$opponentBattersCount.';',CClientScript::POS_HEAD);
    }
    ?>

<head>
</head>
<?
$positions = array('0'=>'*', '1' => 'P', '2' => 'C', '3' => '1B', '4' => '2B', '5' => '3B', '6' => 'SS',
                  '7' => 'LF', '8' => 'CF', '9' => 'RF', '10' => 'EF', '11' => 'DH', '12' => 'PH',
                  '13' => 'PR', '14' => 'CR', '15' => 'EH', '16' => 'X');
?>
<script type="text/javascript">
var positions = <?php echo json_encode($positions); ?>;
var positions = $.map(positions, function(value, index) {
    return [value];
});
    $(document).ready(function(){


        var myTags = ["aaa","PHP", "Perl", "Python"];
                    $('body').delegate('input.ui-autocomplete-input', 'focusin', function() {
                        if($(this).is(':data(autocomplete)')) return;
                        $(this).autocomplete({
                            "source": myTags
                        });
                    });
                    var tagsdiv = $('#tags');

                    //DELETE BUTTON
                    var element = document.createElement("input");

                    //Assign different attributes to the element.
                    /*element.setAttribute("type", 'button');
                    element.setAttribute("value", 'Delete');
                    element.setAttribute("name", 'Delete');
                    element.setAttribute("onClick", 'deleteSustitution');*/


                    $('body').delegate('a.copy', 'click', function(e) {
                        e.preventDefault();
                        $(this).closest('div').prev().after($(this).closest('div').prev().clone());
                        //$(this).closest('div').prev().after(element);

                    });
    });
</script>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'lineup-form',
    'enableAjaxValidation'=>true,
)); ?>

<div class='redbar' style='height:37px'>
    <div class="rightbutton">
        <?php echo CHtml::imageButton('images/button_options.png', array('onClick'=>'submitLink("games/create")')); ?>
    </div>
    <div class="centerbutton">&nbsp;
        <?php
            if ($_GET['team']=='home') {
                $img = 'images/button_home.png';
                $dis = 'disabled';
            } else {
                $img = 'images/button_home_red.png';
                $dis = 'enabled';
            }
        ?>
        <?php echo CHtml::imageButton($img,array($dis=>'true')); ?>
        <?php
            if ($_GET['team']=='visiting') {
                $dis = 'disabled';
                $img = 'images/button_visiting_green.png';
            } else {
                $dis = 'enabled';
                $img = 'images/button_visiting.png';
            }
        ?>
        <?php echo CHtml::imageButton($img,array($dis=>'true') ); ?>
    </div>
</div>
    
    
    <?php   echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->hiddenField($model,'idlineup'); ?>
        <?php echo $form->error($model,'idlineup'); ?>
    </div>



<table id='lineup'>
    
    
    <div id="tags" class="tags">



    <?php //LOAD PLAYERS

    $criteria = new CDbCriteria();
    $criteria->select = array('idplayer','concat(Firstname, " ", Lastname) as Firstname');
    $criteria->addcondition("Teams_idteam=$model->Teams_idteam");
    $criteria->addcondition("status=1");
    $criteria->addcondition("Position!='P'");
    $criteria->order = 'Lastname ASC';


    $Player = new Players;
    $Players = CHtml::listData(Players::model()->findAll($criteria),'idplayer','Firstname');

    $criteria = new CDbCriteria();
    $criteria->select = array('idplayer','concat(Firstname, " ", Lastname) as Firstname');
    $criteria->addcondition("Teams_idteam=$model->Teams_idteam");
    $criteria->addcondition("status=1");
    $criteria->addcondition("Position='P'");
    $criteria->order = 'Lastname ASC';

    $Players = $Players + CHtml::listData(Players::model()->findAll($criteria),'idplayer','Firstname');

    //$Players = CHtml::listData(Players::model()->findAll($criteria),'idplayer','Firstname','Lastname');
    $Batters = new Batters;
    ?>



    <?

    //LOAD BATTERS
    $BattersStoredRaw = array();
    if ($model->idlineup) {
        $criteria = new CDbCriteria();
        $criteria->addcondition("Lineup_idlineup = $model->idlineup");

        $BattersStoredRaw = new Batters;
        $BattersStoredRaw = Batters::model()->findAll($criteria);
    }
    $BattersStored = array();
    foreach ($BattersStoredRaw as $batter) {
        $BattersStored[$batter->BatterPosition][] = $batter;
    }

    for( $i = 1; $i <= 10 ; $i++ ) {
        $title = ($i < 10) ? "Batter $i" : "Pitcher";
        if (empty($BattersStored[$i])) {
            $BattersStored[$i] = array(new Batters());
        }
        ?>
        <div class="blacktitle"><?php echo $title; ?></div>
        <?php
        foreach ($BattersStored[$i] as $currentBatter) {
            $Player->idplayer = $currentBatter->Players_idplayer;
            ?>
            <div class="grayplayer">
                <?php echo $form->textField($currentBatter, 'Number[]', array('id' => 'Batters_Number' . $i, "class" => "inputnumbers", 'value' => $currentBatter['Number'])); ?>
                <div class="batterPlayer" style="width:340px;display:inline-block;">
                    <?php echo $form->dropDownList($Player, 'idplayer[]', $Players,
                        array('id' => 'playerNumberOption' . $i, 'options' => array($Player->idplayer => array('selected' => true)),
                            'empty' => 'Select player',
                            'ajax' => array(
                                'type' => 'POST', //request type
                                'url' => CController::createUrl('lineup/dynamicplayers'), //url to call.
                                'data' => array('idplayer' => 'js:$("#playerNumberOption' . $i . '").val()'),
                                'success' => 'js:function(data) {
                            var data = data.split(";");
                            $("#Batters_Number' . $i . '").val(data[0]);
                            $("#Batters_Number' . $i . '").parent().find(".selectpositions option").removeAttr("selected");
                            $("#Batters_Number' . $i . '").parent().find(".selectpositions option").filter(function () { return $(this).html() == data[1]; }).attr("selected","selected");
                            $("#playerInning' . $i . '").val(1);}'),
                        )); ?>
                </div>
                <?php echo $form->dropDownList($currentBatter, 'DefensePosition[]', $positions, array('class' => 'selectpositions', 'options' => array($currentBatter->DefensePosition => array('selected' => true)))); ?>
                <?php echo $form->hiddenField($currentBatter, 'BatterPosition[]', array('value' => $i)); ?>
                <?php echo $form->textField($currentBatter, 'Inning[]', array('id' => 'playerInning' . $i, "class" => "inputnumbers", 'value' => $currentBatter['Inning'])); ?>
                <?php echo $form->error($Batters, 'Inning'); ?>
            </div>
        <?php
        }
        ?>

        <div class="black">
            <a href="#" class="copy">Enter Substitution</a>
        </div>
        <div class="clear"></div>
    <?php
    }
    ?>
</table>


    <div class="row">
        <?php echo $form->hiddenField($model,'Games_idgame'); ?>
        <?php echo $form->error($model,'Games_idgame'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->hiddenField($model,'Teams_idteam'); ?>
        <?php echo $form->error($model,'Teams_idteam'); ?>
    </div>
              
    <?
    echo CHtml::hiddenField('link','',array('id'=>'link'));
    ?>
    
    <div class="row buttons" style="text-align: center;">
        <?php echo CHtml::submitButton($model->Teams_idteam == Yii::app()->user->getState('idteamhome') ? 
            (Yii::app()->user->getState('idlineuphome') ? 'Update':'Save').' Home Line Up and Switch to Visitor Line Up' : (Yii::app()->user->getState('idlineupvisiting') ? 'Update':'Save').' Visitor Line Up and Switch to Home Line Up',array('class'=>'save-form-btn',"style"=>"width: 500px !important;")); ?>
    </div>
    
    <div class='redbar' style='height:37px'>
        <div class="centerbutton1" style='text-align: center'>
            <a onClick="submitLink('atbat')">
            <?php echo CHtml::image('images/button_batterup.png'); ?>
            </a>
        </div>  
    </div>  
  
<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
$(".save-form-btn").on("click",function(){
    var doWeBreakIt = false;
    $(".grayplayer").find('select[id^=playerNumberOption]').each(function(){
        if($(this).val() != ""){
           
            var a = $(this).parent().parent().find('input,select').each(function(){ 
                if($(this).val() == ""){ 
                    alert("Fill all field for selected players"); 
                    doWeBreakIt = true; 
                    return false;
                }
            });
            if(doWeBreakIt) return false;
        }
    });

    $(".grayplayer").find('select[id^=playerNumberOption]').each(function() {
        var len = $(".grayplayer").find('select[id^=playerNumberOption][value=' + $(this).val() + ']').size();
        if (len > 1 && $(this).val() != "") {
            doWeBreakIt = true; 
            alert("You have entered the same player in Line Up multiple times. All Batters must be unique. Please remove the duplicate(s).");
            return false;
        }
    });


    $(".grayplayer").find(".selectpositions[value!=0]").each(function() {
        var len = $(".grayplayer").find(".selectpositions[value=" + $(this).val() + "]").size();
        if (len > 1 && $(this).val() != "") {
            doWeBreakIt = true; 
            alert("You have entered the same Position for multiple Batters. All positions must be unique. Please correct the duplicate(s).");
            return false;
        }
    });

    if(doWeBreakIt) return false;

    

});
</script>