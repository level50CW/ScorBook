<?php
/* @var $this StatsfieldingController */
/* @var $model Statsfielding */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Idstatsfield'); ?>
		<?php echo $form->textField($model,'Idstatsfield'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Players_idplayer'); ?>
		<?php echo $form->textField($model,'Players_idplayer'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Games_idgames'); ?>
		<?php echo $form->textField($model,'Games_idgames'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'G'); ?>
		<?php echo $form->textField($model,'G'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'GS'); ?>
		<?php echo $form->textField($model,'GS'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'INN'); ?>
		<?php echo $form->textField($model,'INN'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TC'); ?>
		<?php echo $form->textField($model,'TC'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PO'); ?>
		<?php echo $form->textField($model,'PO'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'A'); ?>
		<?php echo $form->textField($model,'A'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'E'); ?>
		<?php echo $form->textField($model,'E'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DP'); ?>
		<?php echo $form->textField($model,'DP'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SB'); ?>
		<?php echo $form->textField($model,'SB'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CS'); ?>
		<?php echo $form->textField($model,'CS'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SBPCT'); ?>
		<?php echo $form->textField($model,'SBPCT'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PB'); ?>
		<?php echo $form->textField($model,'PB'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'C_WP'); ?>
		<?php echo $form->textField($model,'C_WP'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'FPCT'); ?>
		<?php echo $form->textField($model,'FPCT'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'RF'); ?>
		<?php echo $form->textField($model,'RF'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->