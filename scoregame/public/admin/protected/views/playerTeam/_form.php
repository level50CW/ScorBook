<?php
/* @var $this PlayerTeamController */
/* @var $model PlayerTeam */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'player-team-form',
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
		<?php echo $form->labelEx($model,'Teams_idteam'); ?>
		<?php echo $form->textField($model,'Teams_idteam'); ?>
		<?php echo $form->error($model,'Teams_idteam'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Date'); ?>
		<?php echo $form->textField($model,'Date'); ?>
		<?php echo $form->error($model,'Date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array("class"=>"save-form-btn")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->