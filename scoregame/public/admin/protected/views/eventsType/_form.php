<?php
/* @var $this EventsTypeController */
/* @var $model EventsType */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-type-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'idevents_type'); ?>
		<?php echo $form->textField($model,'idevents_type'); ?>
		<?php echo $form->error($model,'idevents_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Name'); ?>
		<?php echo $form->textField($model,'Name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'Name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array("class"=>"save-form-btn")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->