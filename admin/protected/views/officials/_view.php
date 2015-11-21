<?php
/* @var $this OfficialsController */
/* @var $data Officials */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idofficials')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idofficials), array('view', 'id'=>$data->idofficials)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Name')); ?>:</b>
	<?php echo CHtml::encode($data->Name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Lastname')); ?>:</b>
	<?php echo CHtml::encode($data->Lastname); ?>
	<br />


</div>