<?php
/* @var $this TeamsController */
/* @var $data Teams */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idteam')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idteam), array('view', 'id'=>$data->idteam)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Name')); ?>:</b>
	<?php echo CHtml::encode($data->Name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Division_iddivision')); ?>:</b>
	<?php echo CHtml::encode($data->Division_iddivision); ?>
	<br />
	
	
	


</div>