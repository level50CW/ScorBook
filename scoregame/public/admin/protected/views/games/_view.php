<?php
/* @var $this GamesController */
/* @var $data Games */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idgame')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idgame), array('view', 'id'=>$data->idgame)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('location')); ?>:</b>
	<?php echo CHtml::encode($data->location); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
	<?php echo CHtml::encode($data->comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('attendance')); ?>:</b>
	<?php echo CHtml::encode($data->attendance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('weather')); ?>:</b>
	<?php echo CHtml::encode($data->weather); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Teams_idteam_visiting')); ?>:</b>
	<?php echo CHtml::encode($data->Teams_idteam_visiting); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Teams_idteam_home')); ?>:</b>
	<?php echo CHtml::encode($data->Teams_idteam_home); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Division_iddivision_visiting')); ?>:</b>
	<?php echo CHtml::encode($data->Division_iddivision_visiting); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Division_iddivision_home')); ?>:</b>
	<?php echo CHtml::encode($data->Division_iddivision_home); ?>
	<br />

	*/ ?>

</div>