<?php
/* @var $this LeagueController */
/* @var $model League */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'league-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
	'clientOptions' => array(
      'validateOnSubmit' => true,
      'validateOnChange' => false,
	  'afterValidate' => 'js: function(form, data, hasError) {
		  if (!hasError){
			  if ('.$model->isNewRecord.'+0){
				  alert("League "+$(\'input[name="League[Name]"]\').val()+" successfully Added.");
				  location.href = location.href.replace("create","admin");
			  }else{
				  alert("League "+$(\'input[name="League[Name]"]\').val()+" successfully Updated.");
				  location.href = location.href.replace("update","admin");
			  }
		  }
	  }'
    ),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<br/>
	<div class="blacktitle">League</div>

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
		<?php echo CHtml::link('Cancel',array(isset($type) ? 'players/admin':'league/admin'),array('class'=>'save-form-btn'));?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->