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

    $divisions = Division::model()->findAll(array());
    $divisionsList = CHtml::ListData($divisions, 'iddivision', 'Name');

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
                    
                ),
            ));
        }
        ?>

        <?php echo $form->error($model, 'date'); ?>
    </div>
</div>

<div class="rowdiv">
    <div class="green"> Season <span class="required">*</span></div>
    <div class="gray">
        <?php echo $form->textField($model, 'season', array_merge($disabledArray,array('size' => 60, 'maxlength' => 200,"readonly"=>"readonly",))); ?>
        <?php echo $form->error($model, 'season'); ?>
    </div>
</div>

<div class="rowdiv">
    <div class="green"> Status <span class="required">*</span></div>
    <div class="gray">
        <?php echo $form->dropDownList($model, 'status', array(
            '0' => 'created', '1' => 'in progress', '2' => 'End-regulation', '3' => 'End-extraInnings', '4' => 'End-timeLimit', '5' => 'End-runRule', '6' => 'End-forfeit', '7' => 'End-darkness',
            '8' => 'End-rainOut', '9' => 'End-other', '10' => 'Suspended - Darkness', '11' => 'Suspended-rain', '12' => 'Suspended-other'),array_merge($disabledArray,array('style' => 'width:216px !important; text-align:center'))); ?>
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
            array(
				"disabled"=>"disabled",
				"readonly"=>"readonly",
                'style' => 'width:216px !important; text-align:center',
                'empty' => 'Select the division',
                'ajax' => array(
                    'type' => 'POST', //request type
                    'url' => CController::createUrl('games/dynamicteamsHome'), //url to call.
                    //Style: CController::createUrl('currentController/methodToCall')
                    'update' => '#Games_Teams_idteam_home', //selector to update
                    //'data'=>'js:javascript statement'
                    //leave out the data key to pass all form values through
                )));
        ?>
		<?php echo $form->hiddenField($model, 'Division_iddivision_home')?>
        <?php echo $form->error($model, 'Division_iddivision_home'); ?>
    </div>
</div>


<div class="rowdiv">
    <div class="brown"> Team <span class="required">*</span></div>
    <div class="gray">
        <?php //echo $form->textField($model,'Teams_idteam_home'); ?>
        <?php echo $form->dropDownList($model, 'Teams_idteam_home', $model->Teams_idteam_home ? $teamsListHome : array(), array( "disabled"=>"disabled", "readonly"=>"readonly", 'style' => 'width:216px !important; text-align:center','empty' => 'Select the Team')); ?>
        <?php echo $form->hiddenField($model, 'Teams_idteam_home')?>
		<?php echo $form->error($model, 'Teams_idteam_home'); ?>
    </div>
</div>
<div class="rowdiv">
    <div class="green"> Location <span class="required">*</span></div>
    <div class="gray">
        <?php echo $form->textField($model, 'location', array("disabled"=>"disabled", "readonly"=>"readonly",'size' => 60, 'maxlength' => 200)); ?>
        <?php echo $form->hiddenField($model, 'location')?>
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
            array(
				"disabled"=>"disabled",
				"readonly"=>"readonly",
                 'style' => 'width:216px !important; text-align:center',
                'empty' => 'Select the division',
                'ajax' => array(
                    'type' => 'POST', //request type
                    'url' => CController::createUrl('games/dynamicteamsVisiting'), //url to call.
                    //Style: CController::createUrl('currentController/methodToCall')
                    'update' => '#Games_Teams_idteam_visiting', //selector to update
                    //'data'=>'js:javascript statement'
                    //leave out the data key to pass all form values through
                )));
        ?>
		<?php echo $form->hiddenField($model, 'Division_iddivision_visiting')?>
        <?php echo $form->error($model, 'Division_iddivision_visiting'); ?>
    </div>
</div>

<div class="rowdiv">
    <div class="brown"> Team <span class="required">*</span></div>
    <div class="gray">

        <? echo Yii::trace(CVarDumper::dumpAsString($model->Teams_idteam_visiting), 'varVisi'); ?>
        <?php echo $form->dropDownList($model, 'Teams_idteam_visiting', $model->Teams_idteam_visiting ? $teamsList : array(), array( "disabled"=>"disabled", "readonly"=>"readonly", 'style' => 'width:216px !important; text-align:center','empty' => 'Select the Team')); ?>
        <?php echo $form->hiddenField($model, 'Teams_idteam_visiting')?>
		<?php echo $form->error($model, 'Teams_idteam_visiting'); ?>
    </div>
</div>


<? //USERS ID SCOREKEEPER
echo $form->hiddenField($model, 'Users_iduser', array('value' => Yii::app()->user->id));
?>

<div class="clear"></div>

<div class="blacktitle">CONDITIONS</div>
<div class="rowdiv">
    <div class="green">Comment <span class="required">*</span></div>
    <div class="gray">
        <?php echo $form->textField($model, 'comment', array_merge($disabledArray,array('size' => 60, 'maxlength' => 200))); ?>
        <?php echo $form->error($model, 'comment'); ?>
    </div>
</div>
<div class="rowdiv">
    <div class="green">Attendance <span class="required">*</span></div>
    <div class="gray">
        <?php echo $form->textField($model, 'attendance',$disabledArray); ?>
        <?php echo $form->error($model, 'attendance'); ?>
    </div>
</div>
<div class="rowdiv">
    <div class="green">Weather <span class="required">*</span></div>
    <div class="gray">
        <?php //echo $form->textField($model, 'weather', array_merge($disabledArray,array('size' => 60, 'maxlength' => 150))); ?>
        <?php echo $form->dropDownList($model, 'weather', array(
                    'Cloudy' => 'Cloudy',
                    'Overcast' => 'Overcast',
                    'Rain- Intermittent' => 'Rain- Intermittent',
                    'Rain' => 'Rain',
                    'Sleet' => 'Sleet',
                    'Sunny' => 'Sunny',
                    'Thunderstorms' => 'Thunderstorms',),
        array_merge($disabledArray,array('style'=>'width:216px;')));?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>
<div class="rowdiv">
    <div class="green">Temperature <span class="required">*</span></div>
    <div class="gray">
        <?php //echo $form->textField($model, 'weather', array_merge($disabledArray,array('size' => 60, 'maxlength' => 150))); ?>
        <?php echo $form->textField($model, 'temperature',array_merge($disabledArray,array('size' => 4, 'maxlength' => 4, 'style'=>'width:38px; margin-left:-154px;'))); ?> F
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>
<div class="clear"></div>

<div class="blacktitle"> OFFICIALS</div>
<div class="rowdiv">
    <div class="brown">Plate Ump <span class="required">*</span></div>
    <div class="gray">
        <?php echo $form->textField($model, 'Plateump', array_merge($disabledArray,array('size' => 60, 'maxlength' => 200))); ?>
        <?php echo $form->error($model, 'Plateump'); ?>
    </div>
</div>
<div class="rowdiv">
    <div class="brown">Field Ump 1 <span class="required">*</span></div>
    <div class="gray">
        <?php echo $form->textField($model, 'Fieldump1', array_merge($disabledArray,array('size' => 60, 'maxlength' => 200))); ?>
        <?php echo $form->error($model, 'Fieldump1'); ?>
    </div>
</div>
<div class="rowdiv">
    <div class="brown">Field Ump 2 <span class="required">*</span></div>
    <div class="gray">
        <?php echo $form->textField($model, 'Fieldump2', array_merge($disabledArray,array('size' => 60, 'maxlength' => 200))); ?>
        <?php echo $form->error($model, 'Fieldump2'); ?>
    </div>
</div>
<div class="rowdiv">
    <div class="brown">Field Ump 3 <span class="required">*</span></div>
    <div class="gray">
        <?php echo $form->textField($model, 'Fieldump3', array_merge($disabledArray,array('size' => 60, 'maxlength' => 200))); ?>
        <?php echo $form->error($model, 'Fieldump3'); ?>
    </div>
</div>
<div class="rowdiv">
    <div class="brown">Field Ump 4</div>
    <div class="gray">
        <?php echo $form->textField($model, 'Fieldump4', array_merge($disabledArray,array('size' => 60, 'maxlength' => 200))); ?>
        <?php echo $form->error($model, 'Fieldump4'); ?>
    </div>
</div>
<div class="rowdiv">
    <div class="brown">Field Ump 5</div>
    <div class="gray">
        <?php echo $form->textField($model, 'Fieldump5', array_merge($disabledArray,array('size' => 60, 'maxlength' => 200))); ?>
        <?php echo $form->error($model, 'Fieldump5'); ?>
    </div>
</div>
<?
echo CHtml::hiddenField('link', '', array('id' => 'link'));
?>

<br>
<?php if( !isset($disabled) ){ ?>
    <div class="rowdiv">
        <?php echo CHtml::button('Update', array('onClick' => 'submitLink("gamescreate")','class'=>'save-form-btn')); ?>
        <?php echo CHtml::link('Cancel',array('scoreGame/admin'),array('class'=>'save-form-btn', "onclick"=>'
			if (scoreGame_form_isChanged)
				return confirm("You have added data are you sure you want to cancel?");
			else
				return true;'));?>
    </div>
<?php } ?>
<?php $this->endWidget(); ?>

</div><!-- form -->

<?php
Yii::app()->clientScript->registerScript('update', "
$('input[name=\"Games[date]\"]').on('change',function(){
    var date = $(this).val().split('-');
    $('input[name=\"Games[season]\"]').val(date[0]);
});
"); ?>

<script>
$("#games-form").submit(form_onSubmit);

scoreGame_form_isChanged = false;
(function(){
	$("input").change(function(){
		scoreGame_form_isChanged = true;
	});
	
	
})();

function scoreGame_form_validate(){
	function checkAll(args, check){
		for(var i in args){
			if (check(args[i]))
				return true;
		}
		return false;
	}
	
	function isEmpty(){
		return checkAll(arguments, function(a){
			return $(a).val() == ""
		});
	}
	
	function isNumber(){
		return checkAll(arguments, function(a){
			return +$(a).val() == $(a).val()
		});
	}
	
	if (isEmpty("#Games_comment", "#Games_Plateump", "#Games_Fieldump1", "#Games_Fieldump2", "#Games_Fieldump3") ||
		!isNumber("#Games_temperature","#Games_attendance")){
		alert("Please, fill all required fields.");
		return false;
	}else{
		return true;
	}
}

function form_onSubmit(){
	return scoreGame_form_validate();
}
</script>