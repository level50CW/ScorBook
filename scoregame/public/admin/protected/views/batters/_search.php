<?php
/* @var $this BattersController */
/* @var $model Batters */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idbatter'); ?>
		<?php echo $form->textField($model,'idbatter'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Position'); ?>
		<?php echo $form->textField($model,'Position',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Players_idplayer'); ?>
		<?php echo $form->textField($model,'Players_idplayer'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Number'); ?>
		<?php echo $form->textField($model,'Number'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Batterscol'); ?>
		<?php echo $form->textField($model,'Batterscol',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->