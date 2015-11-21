<?php
/* @var $this BattersController */
/* @var $data Batters */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idbatter')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idbatter), array('view', 'id'=>$data->idbatter)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Position')); ?>:</b>
	<?php echo CHtml::encode($data->Position); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Players_idplayer')); ?>:</b>
	<?php echo CHtml::encode($data->Players_idplayer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Number')); ?>:</b>
	<?php echo CHtml::encode($data->Number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Batterscol')); ?>:</b>
	<?php echo CHtml::encode($data->Batterscol); ?>
	<br />


</div>