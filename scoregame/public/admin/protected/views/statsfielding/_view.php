<?php
/* @var $this StatsfieldingController */
/* @var $data Statsfielding */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Idstatsfield')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Idstatsfield), array('view', 'id'=>$data->Idstatsfield)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Players_idplayer')); ?>:</b>
	<?php echo CHtml::encode($data->Players_idplayer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Games_idgames')); ?>:</b>
	<?php echo CHtml::encode($data->Games_idgames); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('G')); ?>:</b>
	<?php echo CHtml::encode($data->G); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('GS')); ?>:</b>
	<?php echo CHtml::encode($data->GS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('INN')); ?>:</b>
	<?php echo CHtml::encode($data->INN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TC')); ?>:</b>
	<?php echo CHtml::encode($data->TC); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('PO')); ?>:</b>
	<?php echo CHtml::encode($data->PO); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('A')); ?>:</b>
	<?php echo CHtml::encode($data->A); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('E')); ?>:</b>
	<?php echo CHtml::encode($data->E); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DP')); ?>:</b>
	<?php echo CHtml::encode($data->DP); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SB')); ?>:</b>
	<?php echo CHtml::encode($data->SB); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CS')); ?>:</b>
	<?php echo CHtml::encode($data->CS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SBPCT')); ?>:</b>
	<?php echo CHtml::encode($data->SBPCT); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PB')); ?>:</b>
	<?php echo CHtml::encode($data->PB); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('C_WP')); ?>:</b>
	<?php echo CHtml::encode($data->C_WP); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FPCT')); ?>:</b>
	<?php echo CHtml::encode($data->FPCT); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('RF')); ?>:</b>
	<?php echo CHtml::encode($data->RF); ?>
	<br />

	*/ ?>

</div>