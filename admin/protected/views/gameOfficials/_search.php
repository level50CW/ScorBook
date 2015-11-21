<?php
/* @var $this GameOfficialsController */
/* @var $model GameOfficials */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idGameOfficials'); ?>
		<?php echo $form->textField($model,'idGameOfficials'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Games_idgame'); ?>
		<?php echo $form->textField($model,'Games_idgame'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Officials_idofficials'); ?>
		<?php echo $form->textField($model,'Officials_idofficials'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Position'); ?>
		<?php echo $form->textField($model,'Position',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->