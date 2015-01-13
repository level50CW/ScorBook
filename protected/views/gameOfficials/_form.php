<?php
/* @var $this GameOfficialsController */
/* @var $model GameOfficials */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'game-officials-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'idGameOfficials'); ?>
		<?php echo $form->textField($model,'idGameOfficials'); ?>
		<?php echo $form->error($model,'idGameOfficials'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Games_idgame'); ?>
		<?php echo $form->textField($model,'Games_idgame'); ?>
		<?php echo $form->error($model,'Games_idgame'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Officials_idofficials'); ?>
		<?php echo $form->textField($model,'Officials_idofficials'); ?>
		<?php echo $form->error($model,'Officials_idofficials'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Position'); ?>
		<?php echo $form->textField($model,'Position',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'Position'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array("class"=>"save-form-btn")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->