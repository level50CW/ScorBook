<?php
/* @var $this RunsController */
/* @var $model Runs */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idrun'); ?>
		<?php echo $form->textField($model,'idrun'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'teams_idteam'); ?>
		<?php echo $form->textField($model,'teams_idteam'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inning1'); ?>
		<?php echo $form->textField($model,'inning1'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inning2'); ?>
		<?php echo $form->textField($model,'inning2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inning3'); ?>
		<?php echo $form->textField($model,'inning3'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inning4'); ?>
		<?php echo $form->textField($model,'inning4'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inning5'); ?>
		<?php echo $form->textField($model,'inning5'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inning6'); ?>
		<?php echo $form->textField($model,'inning6'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inning7'); ?>
		<?php echo $form->textField($model,'inning7'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inning8'); ?>
		<?php echo $form->textField($model,'inning8'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inning9'); ?>
		<?php echo $form->textField($model,'inning9'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'R'); ?>
		<?php echo $form->textField($model,'R'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'H'); ?>
		<?php echo $form->textField($model,'H'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'E'); ?>
		<?php echo $form->textField($model,'E'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'games_idgame'); ?>
		<?php echo $form->textField($model,'games_idgame'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->