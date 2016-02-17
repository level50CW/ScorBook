<?php
/* @var $this StatshittingController */
/* @var $model Statshitting */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'statshitting-form',
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
		<?php echo $form->labelEx($model,'Games_idgame'); ?>
		<?php echo $form->textField($model,'Games_idgame'); ?>
		<?php echo $form->error($model,'Games_idgame'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'G'); ?>
		<?php echo $form->textField($model,'G'); ?>
		<?php echo $form->error($model,'G'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'AB'); ?>
		<?php echo $form->textField($model,'AB'); ?>
		<?php echo $form->error($model,'AB'); ?>
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
		<?php echo $form->labelEx($model,'v2B'); ?>
		<?php echo $form->textField($model,'v2B'); ?>
		<?php echo $form->error($model,'v2B'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'v3B'); ?>
		<?php echo $form->textField($model,'v3B'); ?>
		<?php echo $form->error($model,'v3B'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'HR'); ?>
		<?php echo $form->textField($model,'HR'); ?>
		<?php echo $form->error($model,'HR'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'RBI'); ?>
		<?php echo $form->textField($model,'RBI'); ?>
		<?php echo $form->error($model,'RBI'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'BB'); ?>
		<?php echo $form->textField($model,'BB'); ?>
		<?php echo $form->error($model,'BB'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SO'); ?>
		<?php echo $form->textField($model,'SO'); ?>
		<?php echo $form->error($model,'SO'); ?>
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
		<?php echo $form->labelEx($model,'AVG'); ?>
		<?php echo $form->textField($model,'AVG'); ?>
		<?php echo $form->error($model,'AVG'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'OBP'); ?>
		<?php echo $form->textField($model,'OBP'); ?>
		<?php echo $form->error($model,'OBP'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SLG'); ?>
		<?php echo $form->textField($model,'SLG'); ?>
		<?php echo $form->error($model,'SLG'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'OPS'); ?>
		<?php echo $form->textField($model,'OPS'); ?>
		<?php echo $form->error($model,'OPS'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'IBB'); ?>
		<?php echo $form->textField($model,'IBB'); ?>
		<?php echo $form->error($model,'IBB'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'HBP'); ?>
		<?php echo $form->textField($model,'HBP'); ?>
		<?php echo $form->error($model,'HBP'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SAC'); ?>
		<?php echo $form->textField($model,'SAC'); ?>
		<?php echo $form->error($model,'SAC'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SF'); ?>
		<?php echo $form->textField($model,'SF'); ?>
		<?php echo $form->error($model,'SF'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'TB'); ?>
		<?php echo $form->textField($model,'TB'); ?>
		<?php echo $form->error($model,'TB'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'XBH'); ?>
		<?php echo $form->textField($model,'XBH'); ?>
		<?php echo $form->error($model,'XBH'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'GDP'); ?>
		<?php echo $form->textField($model,'GDP'); ?>
		<?php echo $form->error($model,'GDP'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'GO'); ?>
		<?php echo $form->textField($model,'GO'); ?>
		<?php echo $form->error($model,'GO'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'AO'); ?>
		<?php echo $form->textField($model,'AO'); ?>
		<?php echo $form->error($model,'AO'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'GO_AO'); ?>
		<?php echo $form->textField($model,'GO_AO'); ?>
		<?php echo $form->error($model,'GO_AO'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'NP'); ?>
		<?php echo $form->textField($model,'NP'); ?>
		<?php echo $form->error($model,'NP'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'PA'); ?>
		<?php echo $form->textField($model,'PA'); ?>
		<?php echo $form->error($model,'PA'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->