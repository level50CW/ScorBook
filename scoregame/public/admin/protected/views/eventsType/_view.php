<?php
/* @var $this EventsTypeController */
/* @var $data EventsType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idevents_type')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idevents_type), array('view', 'id'=>$data->idevents_type)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Name')); ?>:</b>
	<?php echo CHtml::encode($data->Name); ?>
	<br />


</div>