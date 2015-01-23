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

    $divisions = Division::model()->findAll();
    $divisionsListHome = CHtml::ListData($divisions, 'iddivision', 'Name');

    $divisions = Division::model()->findAll();
    $divisionsList = CHtml::ListData($divisions, 'iddivision', 'Name');

}else if (Yii::app()->session['role'] == 'roster') {

    $divisions = Division::model()->findAllBySql("SELECT l.iddivision,l.Name FROM Division as l INNER JOIN Teams t ON(l.iddivision = t.Division_iddivision) WHERE l.type = 'division' AND idteam=:a",array(':a' => $team_selected,));
    $divisionsListHome = CHtml::ListData($divisions, 'iddivision', 'Name');

    $divisions = Division::model()->findAll();
    $divisionsList = CHtml::ListData($divisions, 'iddivision', 'Name');

}

if (Yii::app()->session['role'] == 'admins') {
    $teams = Teams::model()->findAll(array('order' => 'Name'));
    $teamsListHome = CHtml::ListData($teams, 'idteam', 'Name');

    $teams = Teams::model()->findAll(array('order' => 'Name'));
    $teamsList = CHtml::ListData($teams, 'idteam', 'Name');

} else if (Yii::app()->session['role'] == 'roster') {
    $teams = Teams::model()->findAll(array("condition" => "idteam =  $team_selected", 'order' => 'Name'));
    $teamsListHome = CHtml::ListData($teams, 'idteam', 'Name');

    $teams = Teams::model()->findAll(array('order' => 'Name'));
    $teamsList = CHtml::ListData($teams, 'idteam', 'Name');
}

?>


<?php echo $form->errorSummary($model); ?>

<br/>
<div class="blacktitle"> GAME INFO</div>
<div class="rowdiv">

    <div class="green"> Date <span class="required">*</span></div>
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
                    'timeFormat'=>'hh:mm',
                    'dateFormat' => 'mm-dd-yy'
                ),
            ));
        }
        ?>

        <?php echo $form->error($model, 'date'); ?>
    </div>
</div>

<div class="rowdiv">
    <div class="brown"> Season <span class="required">*</span></div>
    <div class="gray">
        <?php $model->season = $model->season ? $model->season : date("Y"); ?>
        <?php echo $form->textField($model, 'season', array_merge(array("readonly"=>"readonly"),array('size' => 60, 'maxlength' => 200, 'readonly'=>'readonly'))); ?>
        <?php echo $form->error($model, 'season'); ?>
    </div>
</div>



<div class="rowdiv">
    <div class="green"> Status <span class="required">*</span></div>
    <div class="gray">
        <?php echo $form->dropDownList($model, 'status', array(
            '0' => 'Scheduled – Active', '1' => 'in progress', '2' => 'End-regulation', '3' => 'End-extraInnings', '4' => 'End-timeLimit', '5' => 'End-runRule', '6' => 'End-forfeit', '7' => 'End-darkness',
            '8' => 'End-rainOut', '9' => 'End-other', '10' => 'Suspended - Darkness', '11' => 'Suspended-rain', '12' => 'Suspended-other'),array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center')));?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>

<div class="clear"></div>

<div class="blacktitle"> HOME TEAM</div>
<div class="rowdiv">
    <div class="green"> Division <span class="required">*</span></div>
    <div class="gray">
        <?
        echo $form->dropDownList($model, 'Division_iddivision_home', $divisionsListHome,
            array_merge($disabledArray,
            array(
                'empty' => 'Select Division',
                'style' => 'width:216px !important; text-align:center',
                'ajax' => array(
                    'type' => 'POST', //request type
                    'url' => CController::createUrl('games/dynamicteamsHome'), //url to call.
                    //Style: CController::createUrl('currentController/methodToCall')
                    'update' => '#Games_Teams_idteam_home', //selector to update
                    //'data'=>'js:javascript statement'
                    //leave out the data key to pass all form values through
                ))));
        ?>
        <?php echo $form->error($model, 'Division_iddivision_home'); ?>
    </div>
</div>


<div class="rowdiv">
    <div class="brown"> Team <span class="required">*</span></div>
    <div class="gray">
        <?php //echo $form->textField($model,'Teams_idteam_home'); ?>
        <?php echo $form->dropDownList($model, 'Teams_idteam_home', $model->Teams_idteam_home ? $teamsListHome : array(), array_merge($disabledArray,array('empty' => 'Select Team', 'style' => 'width:216px !important; text-align:center',))); ?>
        <?php echo $form->error($model, 'Teams_idteam_home'); ?>
    </div>
</div>
<div class="rowdiv">
    <div class="green"> Stadium <span class="required">*</span></div>
    <div class="gray">
        <?php
            $tmpLocList = CHtml::listData(Teams::model()->findAll(),'location','idteam');
            $locSTR = $model->location;
            if (!empty($locSTR)) {
                $model->location = $tmpLocList[$model->location];
            }
        ?>
        <?php echo $form->dropDownList($model, 'location', CHtml::listData(Teams::model()->findAll(), 'idteam', 'location'), array('empty' => '', 'style' => 'width:216px !important; text-align:center; display:none;','readonly'=>'readonly')); ?>
        <?php echo CHtml::textField('locationTF', $locSTR ,array('readonly'=>'readonly')); ?>
        <?php echo $form->error($model, 'location'); ?>
    </div>
</div>
<div class="clear">

</div>

<div class="blacktitle"> VISITING TEAM</div>
<div class="rowdiv">
    <div class="green"> Division <span class="required">*</span></div>
    <div class="gray">
        <?
        echo $form->dropDownList($model, 'Division_iddivision_visiting', $divisionsList,
            array_merge($disabledArray,
            array(
                'empty' => 'Select Division',
                'ajax' => array(
                    'type' => 'POST', //request type
                    'url' => CController::createUrl('games/dynamicteamsVisiting'), //url to call.
                    //Style: CController::createUrl('currentController/methodToCall')
                    'update' => '#Games_Teams_idteam_visiting', //selector to update
                    //'data'=>'js:javascript statement'
                    //leave out the data key to pass all form values through
                    
                ))));
        ?>
        <?php echo $form->error($model, 'Division_iddivision_visiting'); ?>
    </div>
</div>

<div class="rowdiv">
    <div class="brown"> Team <span class="required">*</span></div>
    <div class="gray">
        <? echo Yii::trace(CVarDumper::dumpAsString($model->Teams_idteam_visiting), 'varVisi'); ?>
        <?php echo $form->dropDownList($model, 'Teams_idteam_visiting', $model->Teams_idteam_visiting ? $teamsList : array(), array_merge($disabledArray,array('empty' => 'Select Team'))); ?>
    </div>
</div>


<? //USERS ID SCOREKEEPER
echo $form->hiddenField($model, 'Users_iduser', array('value' => Yii::app()->user->id));
?>

<?
echo CHtml::hiddenField('link', '', array('id' => 'link'));;
?>

<br>
<?php if( !isset($disabled) ){ ?>
    <div class="rowdiv">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update', array('class'=>'save-form-btn','style'=>'margin-top: 0;',
        'onClick'=> !$model->isNewRecord ? 'alert("Game on "+$(\'input[name="Games[date]"]\').val().split(" ")[0]+" at "+$(\'input[name="Games[date]"]\').val().split(" ")[1]+ " between "+$(\'select[name="Games[Teams_idteam_home]"] option:selected\').text()+" and "+$(\'select[name="Games[Teams_idteam_visiting]"] option:selected\').text()+" was successfully updated.")' : 'alert("Game on "+$(\'input[name="Games[date]"]\').val().split(" ")[0]+" at "+$(\'input[name="Games[date]"]\').val().split(" ")[1]+ " between "+$(\'select[name="Games[Teams_idteam_home]"] option:selected\').text()+" and "+$(\'select[name="Games[Teams_idteam_visiting]"] option:selected\').text()+" was successfully added to the Schedule.")')); ?>
        <?php echo CHtml::linkButton('Cancel',array('submit'=>array('schedule/admin', 'Schedule_page'=>isset(Yii::app()->session['Schedule_page']) ? Yii::app()->session['Schedule_page'] : 1),'class'=>'save-form-btn'));?>
    </div>
<?php } 
else { ?>
    <div class="rowdiv">
        <?php echo CHtml::linkButton('Close',array('submit'=>array('schedule/admin', 'Schedule_page'=>isset(Yii::app()->session['Schedule_page']) ? Yii::app()->session['Schedule_page'] : 1),'class'=>'save-form-btn'));?>
    </div>
<?php } ?>

<?php $this->endWidget(); ?>

</div><!-- form -->


<?php
Yii::app()->clientScript->registerScript('update', "
$('input[name=\"Games[date]\"]').on('change',function(){
    var date = $(this).datepicker('getDate');
    $('input[name=\"Games[season]\"]').val(date.getFullYear());
});

$('select[name=\"Games[Teams_idteam_home]\"]').on('change',function(){
    $('select[name=\"Games[location]\"]').val($(this).val());
    $('#locationTF').val($('select[name=\"Games[location]\"]').find(\"option[value=\"+$(this).val()+\"]\").text());
});

var myVar = setInterval(function(){ 
    $('select[name=\"Games[Teams_idteam_home]\"]').change();
}, 300);

"); ?>