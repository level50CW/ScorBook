<?php
/* @var $this PlayerTeamController */
/* @var $data PlayerTeam */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Players_idplayer')); ?>:</b>
	<?php echo CHtml::encode($data->Players_idplayer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Teams_idteam')); ?>:</b>
	<?php echo CHtml::encode($data->Teams_idteam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Date')); ?>:</b>
	<?php echo CHtml::encode($data->Date); ?>
	<br />


</div>