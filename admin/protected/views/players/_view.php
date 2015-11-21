<?php
/* @var $this PlayersController */
/* @var $data Players */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idplayer')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idplayer), array('view', 'id'=>$data->idplayer)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Firstname')); ?>:</b>
	<?php echo CHtml::encode($data->Firstname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Lastname')); ?>:</b>
	<?php echo CHtml::encode($data->Lastname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Number')); ?>:</b>
	<?php echo CHtml::encode($data->Number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Teams_idteam')); ?>:</b>
	<?php echo CHtml::encode($data->Teams_idteam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Position')); ?>:</b>
	<?php echo CHtml::encode($data->Position); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Bats')); ?>:</b>
	<?php echo CHtml::encode($data->Bats); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Throws')); ?>:</b>
	<?php echo CHtml::encode($data->Throws); ?>
	<br />

	*/ ?>

</div>