<?php
/* @var $this DivisionController */
/* @var $model Division */
/* @var $form CActiveForm */
?>

<?php
$disabledArray = array();
if( isset($disabled) && $disabled ){
	$disabledArray= array(
		"disabled"=>"disabled",
		"readonly"=>"readonly",
	);
}

if ($model->isNewRecord){
	$model->league_idleague = Settings::get()->idleague;
}
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'division-form',
	'enableAjaxValidation'=>true,
	'clientOptions' => array(
      'validateOnSubmit' => true,
      'validateOnChange' => false,
	  'afterValidate' => 'js: function(form, data, hasError) {
		  if (!hasError){
			  if ('.$model->isNewRecord.'+0){
				  alert("Division "+$(\'input[name="Division[Name]"]\').val()+" successfully Added.");
				  location.href = location.href.replace("create","admin");
			  }else{
				  alert("Division "+$(\'input[name="Division[Name]"]\').val()+" successfully Updated.");
				  location.href = location.href.replace("update","admin");
			  }
		  }
	  }'
    ),
)); ?>

	<?php echo $form->errorSummary($model); ?>


<br/>
<div class="blacktitle">Division</div>
<?php
	$leagues = League::model()->findAll();
	$listLeague= CHtml::listData($leagues,'idleague', 'Name');
?>

<div class="rowdiv">
	<div class="green" style="padding: 10px 0;"> League <span class="required">*</span></div>
	<div class="gray" style="padding: 10px 0;">
		<?php echo $form->dropDownList($model,'league_idleague',$listLeague,array('empty' => 'Select League','style' => 'width:216px !important; text-align:center',"disabled"=>"disabled",
		"readonly"=>"readonly"));?>
		<?php echo $form->error($model,'league_idleague'); ?>
	</div>
</div>
<div class="rowdiv">
    <div class="green" style="padding: 10px 0;"> Name <span class="required">*</span></div>
    <div class="gray" style="padding: 10px 0;">
        <?php echo $form->textField($model,'Name',array('size'=>60,'maxlength'=>150)); ?>
        <?php echo $form->error($model,'Name'); ?>
    </div>
</div>

	<br/>
	<div class="rowdiv">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update',array("class"=>"save-form-btn",'style'=>'margin-top: 0;')); ?>
		<?php echo CHtml::link('Cancel',array(isset($type) ? 'players/admin':'division/admin'),array('class'=>'save-form-btn'));?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
