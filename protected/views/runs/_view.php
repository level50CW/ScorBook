<?php
/* @var $this RunsController */
/* @var $data Runs */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idrun')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idrun), array('view', 'id'=>$data->idrun)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('teams_idteam')); ?>:</b>
	<?php echo CHtml::encode($data->teams_idteam); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inning1')); ?>:</b>
	<?php echo CHtml::encode($data->inning1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inning2')); ?>:</b>
	<?php echo CHtml::encode($data->inning2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inning3')); ?>:</b>
	<?php echo CHtml::encode($data->inning3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inning4')); ?>:</b>
	<?php echo CHtml::encode($data->inning4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inning5')); ?>:</b>
	<?php echo CHtml::encode($data->inning5); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('inning6')); ?>:</b>
	<?php echo CHtml::encode($data->inning6); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inning7')); ?>:</b>
	<?php echo CHtml::encode($data->inning7); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inning8')); ?>:</b>
	<?php echo CHtml::encode($data->inning8); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inning9')); ?>:</b>
	<?php echo CHtml::encode($data->inning9); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('R')); ?>:</b>
	<?php echo CHtml::encode($data->R); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('H')); ?>:</b>
	<?php echo CHtml::encode($data->H); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('E')); ?>:</b>
	<?php echo CHtml::encode($data->E); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('games_idgame')); ?>:</b>
	<?php echo CHtml::encode($data->games_idgame); ?>
	<br />

	*/ ?>

</div>