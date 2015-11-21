<?php
/* @var $this BattersController */
/* @var $model Batters */
/* @var $form CActiveForm */
?>





<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'batters-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'idbatter'); ?>
		<?php echo $form->textField($model,'idbatter'); ?>
		<?php echo $form->error($model,'idbatter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Position'); ?>
		<?php echo $form->textField($model,'Position',array('size'=>2,'maxlength'=>2)); ?>
		<?php echo $form->error($model,'Position'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Players_idplayer'); ?>
		<?php echo $form->textField($model,'Players_idplayer'); ?>
		<?php echo $form->error($model,'Players_idplayer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Number'); ?>
		<?php echo $form->textField($model,'Number'); ?>
		<?php echo $form->error($model,'Number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Batterscol'); ?>
		<?php echo $form->textField($model,'Batterscol',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'Batterscol'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array("class"=>"save-form-btn")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->