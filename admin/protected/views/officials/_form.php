<?php
/* @var $this OfficialsController */
/* @var $model Officials */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'officials-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'idofficials'); ?>
		<?php echo $form->textField($model,'idofficials'); ?>
		<?php echo $form->error($model,'idofficials'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Name'); ?>
		<?php echo $form->textField($model,'Name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'Name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Lastname'); ?>
		<?php echo $form->textField($model,'Lastname',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'Lastname'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array("class"=>"save-form-btn")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->