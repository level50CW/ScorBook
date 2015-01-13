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
    $opponentLineup = $opponentLineup[0]->idlineup ? $opponentLineup[0]->idlineup : null;
    
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
        <? if ($_GET['team']=='home') $dis = 'disabled'; else $dis = 'enabled'?>
        <?php echo CHtml::imageButton('images/button_home.png',array($dis=>'true')); ?>
        <? if ($_GET['team']=='visiting') $dis = 'disabled'; else $dis = 'enabled'?>
        <?php echo CHtml::imageButton('images/button_visiting.png',array($dis=>'true') ); ?>
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
    $BattersStored = array();
    if ($model->idlineup) {
        $criteria = new CDbCriteria();
        $criteria->addcondition("Lineup_idlineup = $model->idlineup");

        $BattersStored = new Batters;
        $BattersStored = Batters::model()->findAll($criteria);
    }

    $count = sizeof($BattersStored);
    $i = 0; $j = 0;
    //for( $i = 0; $i < 11 ; $i++ )
    while ($j < 11) 
    {
        //echo $BattersStored[$i]->BatterPosition . " - - " . ($j+1);
        if((integer)$BattersStored[$i]->BatterPosition !== $j+1){
            $in = $j+1;
            ?>
            <div class="blacktitle"> Batter <?=$in?> </div>
            <div class="grayplayer">
                <?php echo $form->textField($Batters,'Number[]',array('id'=>'Batters_Number'.$in,"class"=>"inputnumbers")); ?>
                <div class="batterPlayer" style="width:340px;display:inline-block;">
                <?php
                    echo $form->dropDownList($Player,'idplayer[]',$Players,
                      array('id'=>'playerNumberOption'.$in,
                            'empty'=>'Select player',
                            'ajax' => array(
                                'type'=>'POST',
                                'url'=>CController::createUrl('lineup/dynamicplayers'), //url to call.
                                'data' =>array('idplayer'=>'js:$(this).val()'),
                                'success' => 'js:function(data) { 
                                    var data = data.split(";");
                                    $("#Batters_Number'.$in.'").val(data[0]); 
                                    $("#Batters_Number'.$in.'").parent().find(".selectpositions option").removeAttr("selected");
                                    $("#Batters_Number'.$in.'").parent().find(".selectpositions option").filter(function () { return $(this).html() == data[1]; }).attr("selected","selected"); 
                                    $("#playerInning'.$in.'").val(1);
                        }')
                        ));
                ?>
                </div>
                <?php echo $form->dropDownList($Batters,'DefensePosition[]',$positions,array('class'=>'selectpositions'));?>
                <?php echo $form->hiddenField($Batters,'BatterPosition[]',array('value'=>$in));?>
                <?php echo $form->textField($Batters,'Inning[]',array('id'=>'playerInning'.$in,"class"=>"inputnumbers"));?>
                <?php echo $form->error($Batters,'Inning'); ?>
            </div>
            <div class="black">
                <a href="#" class="copy">Enter Substitution</a>
            </div>
            <div class="clear"></div>
            <?
        }
        else{
            $Player->idplayer = $BattersStored[$i]->Players_idplayer;
            $bat = 1+$j;
            if ($BattersStored[$i]['Inning'] == 1 ){
                echo '<div class="blacktitle"> Batter '. $bat .'  </div>';
            }
            ?>
            <div class="grayplayer">
                <?php echo $form->textField($BattersStored[$i],'Number[]',array('id'=>'Batters_Number'.$i,"class"=>"inputnumbers",'value'=>$BattersStored[$i]['Number'])); ?>
                <div class="batterPlayer" style="width:340px;display:inline-block;">
                    <?php echo $form->dropDownList($Player,'idplayer[]', $Players,  
                         array('id'=>'playerNumberOption'.$i,'options' => array($Player->idplayer=>array('selected'=>true)),
                        'empty'=>'Select player',
                        'ajax' => array(
                        'type'=>'POST', //request type
                        'url'=>CController::createUrl('lineup/dynamicplayers'), //url to call.
                        'data' =>array('idplayer'=>'js:$("#playerNumberOption'.$i.'").val()'),
                        'success' => 'js:function(data) {
                            var data = data.split(";");
                            $("#Batters_Number'.$i.'").val(data[0]);
                            $("#Batters_Number'.$i.'").parent().find(".selectpositions option").removeAttr("selected");
                            $("#Batters_Number'.$i.'").parent().find(".selectpositions option").filter(function () { return $(this).html() == data[1]; }).attr("selected","selected"); 
                            $("#playerInning'.$i.'").val(1);}'),
                        ));?>
               </div>
                <?php echo $form->dropDownList($BattersStored[$i],'DefensePosition[]',$positions,   array('class'=>'selectpositions','options' => array($BattersStored[$i]->DefensePosition => array('selected'=>true))));?>
                <?php echo $form->hiddenField($BattersStored[$i],'BatterPosition[]',array('value' => $bat));?>
                <?php echo $form->textField($BattersStored[$i],'Inning[]',array('id'=>'playerInning'.$i,"class"=>"inputnumbers",'value'=>$BattersStored[$i]['Inning']));?>
                <?php echo $form->error($Batters,'Inning'); ?>
            </div>

            <?//CHECK IF NEXT BATTER IS INNING 1 OR SUBSTITUTION
            if ($bat <= 11){
                if ($BattersStored[$bat]['Inning'] == 1 || $BattersStored[$bat]['Inning'] == '') {
                ?>
                    <div class="black">
                        <a href="#" class="copy">Enter Substitution</a>
                    </div>
                    <div class="clear"></div>
                <? 
                }
            }
            $i++;
        }
        $j++;
        
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