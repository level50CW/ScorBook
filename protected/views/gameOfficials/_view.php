<?php
/* @var $this GameOfficialsController */
/* @var $data GameOfficials */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idGameOfficials')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idGameOfficials), array('view', 'id'=>$data->idGameOfficials)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Games_idgame')); ?>:</b>
	<?php echo CHtml::encode($data->Games_idgame); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Officials_idofficials')); ?>:</b>
	<?php echo CHtml::encode($data->Officials_idofficials); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Position')); ?>:</b>
	<?php echo CHtml::encode($data->Position); ?>
	<br />


</div>