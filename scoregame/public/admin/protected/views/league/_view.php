<?php
/* @var $this LeagueController */
/* @var $data League */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idleague')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idleague), array('view', 'id'=>$data->idleague)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Name')); ?>:</b>
	<?php echo CHtml::encode($data->Name); ?>
	<br />


</div>