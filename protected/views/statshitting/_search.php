<?php
/* @var $this StatshittingController */
/* @var $model Statshitting */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idstatshit'); ?>
		<?php echo $form->textField($model,'idstatshit'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Players_idplayer'); ?>
		<?php echo $form->textField($model,'Players_idplayer'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Games_idgame'); ?>
		<?php echo $form->textField($model,'Games_idgame'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'G'); ?>
		<?php echo $form->textField($model,'G'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'AB'); ?>
		<?php echo $form->textField($model,'AB'); ?>
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
		<?php echo $form->label($model,'v2B'); ?>
		<?php echo $form->textField($model,'v2B'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'v3B'); ?>
		<?php echo $form->textField($model,'v3B'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'HR'); ?>
		<?php echo $form->textField($model,'HR'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'RBI'); ?>
		<?php echo $form->textField($model,'RBI'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'BB'); ?>
		<?php echo $form->textField($model,'BB'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SO'); ?>
		<?php echo $form->textField($model,'SO'); ?>
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
		<?php echo $form->label($model,'AVG'); ?>
		<?php echo $form->textField($model,'AVG'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'OBP'); ?>
		<?php echo $form->textField($model,'OBP'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SLG'); ?>
		<?php echo $form->textField($model,'SLG'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'OPS'); ?>
		<?php echo $form->textField($model,'OPS'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'IBB'); ?>
		<?php echo $form->textField($model,'IBB'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'HBP'); ?>
		<?php echo $form->textField($model,'HBP'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SAC'); ?>
		<?php echo $form->textField($model,'SAC'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SF'); ?>
		<?php echo $form->textField($model,'SF'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TB'); ?>
		<?php echo $form->textField($model,'TB'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'XBH'); ?>
		<?php echo $form->textField($model,'XBH'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'GDP'); ?>
		<?php echo $form->textField($model,'GDP'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'GO'); ?>
		<?php echo $form->textField($model,'GO'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'AO'); ?>
		<?php echo $form->textField($model,'AO'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'GO_AO'); ?>
		<?php echo $form->textField($model,'GO_AO'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NP'); ?>
		<?php echo $form->textField($model,'NP'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PA'); ?>
		<?php echo $form->textField($model,'PA'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->