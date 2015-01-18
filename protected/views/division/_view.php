<?php
/* @var $this DivisionController */
/* @var $data Division */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('iddivision')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->iddivision), array('view', 'id'=>$data->iddivision)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Name')); ?>:</b>
	<?php echo CHtml::encode($data->Name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('league_idleague')); ?>:</b>
	<?php echo CHtml::encode($data->league_idleague); ?>
	<br />


</div>