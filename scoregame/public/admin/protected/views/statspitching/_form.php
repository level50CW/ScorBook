<?php
/* @var $this StatspitchingController */
/* @var $model Statspitching */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'statspitching-form',
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
		<?php echo $form->labelEx($model,'W'); ?>
		<?php echo $form->textField($model,'W'); ?>
		<?php echo $form->error($model,'W'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'L'); ?>
		<?php echo $form->textField($model,'L'); ?>
		<?php echo $form->error($model,'L'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ERA'); ?>
		<?php echo $form->textField($model,'ERA'); ?>
		<?php echo $form->error($model,'ERA'); ?>
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
		<?php echo $form->labelEx($model,'SV'); ?>
		<?php echo $form->textField($model,'SV'); ?>
		<?php echo $form->error($model,'SV'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SVO'); ?>
		<?php echo $form->textField($model,'SVO'); ?>
		<?php echo $form->error($model,'SVO'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'IP'); ?>
		<?php echo $form->textField($model,'IP'); ?>
		<?php echo $form->error($model,'IP'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'H'); ?>
		<?php echo $form->textField($model,'H'); ?>
		<?php echo $form->error($model,'H'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'R'); ?>
		<?php echo $form->textField($model,'R'); ?>
		<?php echo $form->error($model,'R'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ER'); ?>
		<?php echo $form->textField($model,'ER'); ?>
		<?php echo $form->error($model,'ER'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'HR'); ?>
		<?php echo $form->textField($model,'HR'); ?>
		<?php echo $form->error($model,'HR'); ?>
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
		<?php echo $form->labelEx($model,'AVG'); ?>
		<?php echo $form->textField($model,'AVG'); ?>
		<?php echo $form->error($model,'AVG'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'WHIP'); ?>
		<?php echo $form->textField($model,'WHIP'); ?>
		<?php echo $form->error($model,'WHIP'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CG'); ?>
		<?php echo $form->textField($model,'CG'); ?>
		<?php echo $form->error($model,'CG'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SHO'); ?>
		<?php echo $form->textField($model,'SHO'); ?>
		<?php echo $form->error($model,'SHO'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'HB'); ?>
		<?php echo $form->textField($model,'HB'); ?>
		<?php echo $form->error($model,'HB'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'IBB'); ?>
		<?php echo $form->textField($model,'IBB'); ?>
		<?php echo $form->error($model,'IBB'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'GF'); ?>
		<?php echo $form->textField($model,'GF'); ?>
		<?php echo $form->error($model,'GF'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'HLD'); ?>
		<?php echo $form->textField($model,'HLD'); ?>
		<?php echo $form->error($model,'HLD'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'GIDP'); ?>
		<?php echo $form->textField($model,'GIDP'); ?>
		<?php echo $form->error($model,'GIDP'); ?>
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
		<?php echo $form->labelEx($model,'WP'); ?>
		<?php echo $form->textField($model,'WP'); ?>
		<?php echo $form->error($model,'WP'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'BK'); ?>
		<?php echo $form->textField($model,'BK'); ?>
		<?php echo $form->error($model,'BK'); ?>
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
		<?php echo $form->labelEx($model,'PK'); ?>
		<?php echo $form->textField($model,'PK'); ?>
		<?php echo $form->error($model,'PK'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'TBF'); ?>
		<?php echo $form->textField($model,'TBF'); ?>
		<?php echo $form->error($model,'TBF'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'NP'); ?>
		<?php echo $form->textField($model,'NP'); ?>
		<?php echo $form->error($model,'NP'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'WPCT'); ?>
		<?php echo $form->textField($model,'WPCT'); ?>
		<?php echo $form->error($model,'WPCT'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'GO_AO'); ?>
		<?php echo $form->textField($model,'GO_AO'); ?>
		<?php echo $form->error($model,'GO_AO'); ?>
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
		<?php echo $form->labelEx($model,'K_9'); ?>
		<?php echo $form->textField($model,'K_9'); ?>
		<?php echo $form->error($model,'K_9'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'BB_9'); ?>
		<?php echo $form->textField($model,'BB_9'); ?>
		<?php echo $form->error($model,'BB_9'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'K_BB'); ?>
		<?php echo $form->textField($model,'K_BB'); ?>
		<?php echo $form->error($model,'K_BB'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'P_IP'); ?>
		<?php echo $form->textField($model,'P_IP'); ?>
		<?php echo $form->error($model,'P_IP'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->