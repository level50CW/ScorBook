<?php
/* @var $this GamesController */
/* @var $model Games */
/* @var $form CActiveForm */

$disabledArray = array();
if( isset($disabled) && $disabled ){
    $disabledArray= array(
        "disabled"=>"disabled",
        "readonly"=>"readonly",
    );
}


?>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'games-form',
    'enableAjaxValidation' => false,
)); ?>

<div class="row">
    <?php echo $form->hiddenField($model, 'idgame'); ?>
    <?php echo $form->error($model, 'idgame'); ?>
</div>

<?
//Seleccionamos la liga del equipo que tiene el usuario si no es admin

$team_selected = Yii::app()->session['team'];

if (Yii::app()->session['role'] == 'admins') {

    $leagues = League::model()->findAll();
    $leaguesListHome = CHtml::ListData($leagues, 'idleague', 'Name');

    $leagues = League::model()->findAll();
    $leaguesList = CHtml::ListData($leagues, 'idleague', 'Name');

}else if (Yii::app()->session['role'] == 'roster') {

    $leagues = League::model()->findAllBySql("SELECT l.idleague,l.Name FROM League as l INNER JOIN Teams t ON(l.idleague = t.League_idleague) WHERE idteam=:a",array(':a' => $team_selected,));
    $leaguesListHome = CHtml::ListData($leagues, 'idleague', 'Name');

    $leagues = League::model()->findAll();
    $leaguesList = CHtml::ListData($leagues, 'idleague', 'Name');

}

if (Yii::app()->session['role'] == 'admins') {
    $teams = Teams::model()->findAll();
    $teamsListHome = CHtml::ListData($teams, 'idteam', 'Name');

    $teams = Teams::model()->findAll();
    $teamsList = CHtml::ListData($teams, 'idteam', 'Name');

} else if (Yii::app()->session['role'] == 'roster') {
    $teams = Teams::model()->findAll(array("condition" => "idteam =  $team_selected"));
    $teamsListHome = CHtml::ListData($teams, 'idteam', 'Name');

    $teams = Teams::model()->findAll();
    $teamsList = CHtml::ListData($teams, 'idteam', 'Name');
}

?>


<?php echo $form->errorSummary($model); ?>


<div class="blacktitle"> GAME</div>
<div class="rowdiv">

    <div class="green"> Date</div>
    <div class="gray">


        <?php
        if( isset($disabled) && $disabled ){
            echo $form->textField($model, 'date', array_merge($disabledArray,array('size' => 60, 'maxlength' => 200)));
        }
        else{
            $this->widget('application.extensions.timepicker.timepicker', array(
                'model' => $model,
                'name' => 'date', 
                'options' => array(
                    'showOn'=>'focus',
                    
                ),
            ));
        }
        ?>

        <?php echo $form->error($model, 'date'); ?>
    </div>
</div>

<div class="rowdiv">
    <div class="green"> Location</div>
    <div class="gray">
        <?php echo $form->textField($model, 'location', array_merge($disabledArray,array('size' => 60, 'maxlength' => 200))); ?>
        <?php echo $form->error($model, 'location'); ?>
    </div>
</div>

<div class="rowdiv">
    <div class="green"> Status</div>
    <div class="gray">
        <?php echo $form->dropDownList($model, 'status', array(
            '0' => 'created', '1' => 'in progress', '2' => 'End-regulation', '3' => 'End-extraInnings', '4' => 'End-timeLimit', '5' => 'End-runRule', '6' => 'End-forfeit', '7' => 'End-darkness',
            '8' => 'End-rainOut', '9' => 'End-other', '10' => 'Suspended - Darkness', '11' => 'Suspended-rain', '12' => 'Suspended-other'),$disabledArray);?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>

<div class="clear"></div>

<div class="blacktitle"> HOME TEAM</div>
<div class="rowdiv">
    <div class="green"> League</div>
    <div class="gray">
        <?
        echo $form->dropDownList($model, 'League_idleague_home', $leaguesListHome,
            array_merge($disabledArray,
            array(
                'empty' => 'Select the league',
                'ajax' => array(
                    'type' => 'POST', //request type
                    'url' => CController::createUrl('games/dynamicteamsHome'), //url to call.
                    //Style: CController::createUrl('currentController/methodToCall')
                    'update' => '#Games_Teams_idteam_home', //selector to update
                    //'data'=>'js:javascript statement'
                    //leave out the data key to pass all form values through
                ))));
        ?>
        <?php echo $form->error($model, 'League_idleague_home'); ?>
    </div>
</div>


<div class="rowdiv">
    <div class="brown"> Team</div>
    <div class="gray">
        <?php //echo $form->textField($model,'Teams_idteam_home'); ?>
        <?php echo $form->dropDownList($model, 'Teams_idteam_home', $model->Teams_idteam_home ? $teamsListHome : array(), array_merge($disabledArray,array('empty' => 'Select the Team'))); ?>
        <?php echo $form->error($model, 'Teams_idteam_home'); ?>
    </div>
</div>

<div class="clear">

</div>

<div class="blacktitle"> VISITING TEAM</div>
<div class="rowdiv">
    <div class="green"> League</div>
    <div class="gray">
        <?
        echo $form->dropDownList($model, 'League_idleague_visiting', $leaguesList,
            array_merge($disabledArray,
            array(
                'empty' => 'Select the league',
                'ajax' => array(
                    'type' => 'POST', //request type
                    'url' => CController::createUrl('games/dynamicteamsVisiting'), //url to call.
                    //Style: CController::createUrl('currentController/methodToCall')
                    'update' => '#Games_Teams_idteam_visiting', //selector to update
                    //'data'=>'js:javascript statement'
                    //leave out the data key to pass all form values through
                ))));
        ?>
        <?php echo $form->error($model, 'League_idleague_visiting'); ?>
    </div>
</div>

<div class="rowdiv">
    <div class="brown"> Team</div>
    <div class="gray">

        <? echo Yii::trace(CVarDumper::dumpAsString($model->Teams_idteam_visiting), 'varVisi'); ?>
        <?php echo $form->dropDownList($model, 'Teams_idteam_visiting', $model->Teams_idteam_visiting ? $teamsList : array(), array_merge($disabledArray,array('empty' => 'Select the Team'))); ?>
        <?php echo $form->error($model, 'Teams_idteam_visiting'); ?>
    </div>
</div>


<? //USERS ID SCOREKEEPER
echo $form->hiddenField($model, 'Users_iduser', array('value' => Yii::app()->user->id));
?>

<div class="clear"></div>

<div class="blacktitle">CONDITIONS</div>

<div class="rowdiv">

    <div class="green"> Comment</div>
    <div class="gray">
        <?php echo $form->textField($model, 'comment', array_merge($disabledArray,array('size' => 60, 'maxlength' => 200))); ?>
        <?php echo $form->error($model, 'comment'); ?>
    </div>
</div>
<div class="rowdiv">
    <div class="green"> Attendance</div>
    <div class="gray">
        <?php echo $form->textField($model, 'attendance',$disabledArray); ?>
        <?php echo $form->error($model, 'attendance'); ?>
    </div>
</div>
<div class="rowdiv">
    <div class="green"> Weather</div>
    <div class="gray">
        <?php echo $form->textField($model, 'weather', array_merge($disabledArray,array('size' => 60, 'maxlength' => 150))); ?>
        <?php echo $form->error($model, 'weather'); ?>
    </div>
</div>

<?
echo CHtml::hiddenField('link', '', array('id' => 'link'));
?>

<br>
<?php if( !isset($disabled) ){ ?>
<div class='redbar' style='height:37px'>

    <div class="rightbutton">
        <?php echo CHtml::imageButton('images/button_newgame.png', array('onClick' => 'submitLink("gamescreate")')); ?>
    </div>
    <div class="centerbutton">&nbsp;
    </div>
    <div class="leftbutton">
        <?php echo CHtml::imageButton('images/button_lineup.png'); ?>
    </div>
</div>
<?php } ?>
<?php $this->endWidget(); ?>

</div><!-- form -->