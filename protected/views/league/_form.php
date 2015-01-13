<?php
/* @var $this LeagueController */
/* @var $model League */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'league-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>


<br/>
<div class="blacktitle"><?php echo isset($type) ? $type: 'Division'; ?></div>
<div class="rowdiv">

    <div class="green" style="padding: 10px 0;"> Name</div>
    <div class="gray" style="padding: 10px 0;">
		<?php echo $form->textField($model,'Name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'Name'); ?>
    </div>
</div>
<br/>
	<div class="rowdiv">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Update',array("class"=>"save-form-btn",'style'=>'margin-top: 0;','onClick'=> $model->isNewRecord ? 'alert("Division "+$(\'input[name="League[Name]"]\').val()+" successfully Added.")' : '')); ?>
		<?php echo CHtml::linkButton('Cancel',array('submit'=>array(isset($type) ? 'players/admin':'league/admin'),'class'=>'save-form-btn'));?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
