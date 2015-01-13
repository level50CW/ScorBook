<?php
/* @var $this EventsController */
/* @var $model Events */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idevents'); ?>
		<?php echo $form->textField($model,'idevents'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Comment'); ?>
		<?php echo $form->textField($model,'Comment',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Lineup_idlineup'); ?>
		<?php echo $form->textField($model,'Lineup_idlineup'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Events_type_idevents_type'); ?>
		<?php echo $form->textField($model,'Events_type_idevents_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Inning'); ?>
		<?php echo $form->textField($model,'Inning'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->