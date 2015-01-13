<?php
/* @var $this EventsController */
/* @var $data Events */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idevents')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idevents), array('view', 'id'=>$data->idevents)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Comment')); ?>:</b>
	<?php echo CHtml::encode($data->Comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Lineup_idlineup')); ?>:</b>
	<?php echo CHtml::encode($data->Lineup_idlineup); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Events_type_idevents_type')); ?>:</b>
	<?php echo CHtml::encode($data->Events_type_idevents_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Inning')); ?>:</b>
	<?php echo CHtml::encode($data->Inning); ?>
	<br />


</div>