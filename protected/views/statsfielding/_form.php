<?php
/* @var $this StatsfieldingController */
/* @var $model Statsfielding */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'statsfielding-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Players_idplayer'); ?>
		<?php echo $form->textField($model,'Players_idplayer'); ?>
		<?php echo $form->error($model,'Players_idplayer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Games_idgames'); ?>
		<?php echo $form->textField($model,'Games_idgames'); ?>
		<?php echo $form->error($model,'Games_idgames'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'G'); ?>
		<?php echo $form->textField($model,'G'); ?>
		<?php echo $form->error($model,'G'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'GS'); ?>
		<?php echo $form->textField($model,'GS'); ?>
		<?php echo $form->error($model,'GS'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'INN'); ?>
		<?php echo $form->textField($model,'INN'); ?>
		<?php echo $form->error($model,'INN'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'TC'); ?>
		<?php echo $form->textField($model,'TC'); ?>
		<?php echo $form->error($model,'TC'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'PO'); ?>
		<?php echo $form->textField($model,'PO'); ?>
		<?php echo $form->error($model,'PO'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'A'); ?>
		<?php echo $form->textField($model,'A'); ?>
		<?php echo $form->error($model,'A'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'E'); ?>
		<?php echo $form->textField($model,'E'); ?>
		<?php echo $form->error($model,'E'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'DP'); ?>
		<?php echo $form->textField($model,'DP'); ?>
		<?php echo $form->error($model,'DP'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SB'); ?>
		<?php echo $form->textField($model,'SB'); ?>
		<?php echo $form->error($model,'SB'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CS'); ?>
		<?php echo $form->textField($model,'CS'); ?>
		<?php echo $form->error($model,'CS'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SBPCT'); ?>
		<?php echo $form->textField($model,'SBPCT'); ?>
		<?php echo $form->error($model,'SBPCT'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'PB'); ?>
		<?php echo $form->textField($model,'PB'); ?>
		<?php echo $form->error($model,'PB'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'C_WP'); ?>
		<?php echo $form->textField($model,'C_WP'); ?>
		<?php echo $form->error($model,'C_WP'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'FPCT'); ?>
		<?php echo $form->textField($model,'FPCT'); ?>
		<?php echo $form->error($model,'FPCT'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'RF'); ?>
		<?php echo $form->textField($model,'RF'); ?>
		<?php echo $form->error($model,'RF'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->