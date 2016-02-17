<?php
/* @var $this StatspitchingController */
/* @var $model Statspitching */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'idstatspit'); ?>
		<?php echo $form->textField($model,'idstatspit'); ?>
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
		<?php echo $form->label($model,'W'); ?>
		<?php echo $form->textField($model,'W'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'L'); ?>
		<?php echo $form->textField($model,'L'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ERA'); ?>
		<?php echo $form->textField($model,'ERA'); ?>
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
		<?php echo $form->label($model,'SV'); ?>
		<?php echo $form->textField($model,'SV'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SVO'); ?>
		<?php echo $form->textField($model,'SVO'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'IP'); ?>
		<?php echo $form->textField($model,'IP'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'H'); ?>
		<?php echo $form->textField($model,'H'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'R'); ?>
		<?php echo $form->textField($model,'R'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ER'); ?>
		<?php echo $form->textField($model,'ER'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'HR'); ?>
		<?php echo $form->textField($model,'HR'); ?>
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
		<?php echo $form->label($model,'AVG'); ?>
		<?php echo $form->textField($model,'AVG'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'WHIP'); ?>
		<?php echo $form->textField($model,'WHIP'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CG'); ?>
		<?php echo $form->textField($model,'CG'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SHO'); ?>
		<?php echo $form->textField($model,'SHO'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'HB'); ?>
		<?php echo $form->textField($model,'HB'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'IBB'); ?>
		<?php echo $form->textField($model,'IBB'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'GF'); ?>
		<?php echo $form->textField($model,'GF'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'HLD'); ?>
		<?php echo $form->textField($model,'HLD'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'GIDP'); ?>
		<?php echo $form->textField($model,'GIDP'); ?>
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
		<?php echo $form->label($model,'WP'); ?>
		<?php echo $form->textField($model,'WP'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'BK'); ?>
		<?php echo $form->textField($model,'BK'); ?>
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
		<?php echo $form->label($model,'PK'); ?>
		<?php echo $form->textField($model,'PK'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TBF'); ?>
		<?php echo $form->textField($model,'TBF'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NP'); ?>
		<?php echo $form->textField($model,'NP'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'WPCT'); ?>
		<?php echo $form->textField($model,'WPCT'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'GO_AO'); ?>
		<?php echo $form->textField($model,'GO_AO'); ?>
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
		<?php echo $form->label($model,'K_9'); ?>
		<?php echo $form->textField($model,'K_9'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'BB_9'); ?>
		<?php echo $form->textField($model,'BB_9'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'K_BB'); ?>
		<?php echo $form->textField($model,'K_BB'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'P_IP'); ?>
		<?php echo $form->textField($model,'P_IP'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->