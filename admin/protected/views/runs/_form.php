<?php
/* @var $this RunsController */
/* @var $model Runs */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'runs-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'idrun'); ?>
		<?php echo $form->textField($model,'idrun'); ?>
		<?php echo $form->error($model,'idrun'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'teams_idteam'); ?>
		<?php echo $form->textField($model,'teams_idteam'); ?>
		<?php echo $form->error($model,'teams_idteam'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inning1'); ?>
		<?php echo $form->textField($model,'inning1'); ?>
		<?php echo $form->error($model,'inning1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inning2'); ?>
		<?php echo $form->textField($model,'inning2'); ?>
		<?php echo $form->error($model,'inning2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inning3'); ?>
		<?php echo $form->textField($model,'inning3'); ?>
		<?php echo $form->error($model,'inning3'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inning4'); ?>
		<?php echo $form->textField($model,'inning4'); ?>
		<?php echo $form->error($model,'inning4'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inning5'); ?>
		<?php echo $form->textField($model,'inning5'); ?>
		<?php echo $form->error($model,'inning5'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inning6'); ?>
		<?php echo $form->textField($model,'inning6'); ?>
		<?php echo $form->error($model,'inning6'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inning7'); ?>
		<?php echo $form->textField($model,'inning7'); ?>
		<?php echo $form->error($model,'inning7'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inning8'); ?>
		<?php echo $form->textField($model,'inning8'); ?>
		<?php echo $form->error($model,'inning8'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inning9'); ?>
		<?php echo $form->textField($model,'inning9'); ?>
		<?php echo $form->error($model,'inning9'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'R'); ?>
		<?php echo $form->textField($model,'R'); ?>
		<?php echo $form->error($model,'R'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'H'); ?>
		<?php echo $form->textField($model,'H'); ?>
		<?php echo $form->error($model,'H'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'E'); ?>
		<?php echo $form->textField($model,'E'); ?>
		<?php echo $form->error($model,'E'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'games_idgame'); ?>
		<?php echo $form->textField($model,'games_idgame'); ?>
		<?php echo $form->error($model,'games_idgame'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array("class"=>"save-form-btn")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->