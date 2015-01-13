<?php
/* @var $this StatspitchingController */
/* @var $data Statspitching */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('idstatspit')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->idstatspit), array('view', 'id'=>$data->idstatspit)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Players_idplayer')); ?>:</b>
	<?php echo CHtml::encode($data->Players_idplayer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Games_idgame')); ?>:</b>
	<?php echo CHtml::encode($data->Games_idgame); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('W')); ?>:</b>
	<?php echo CHtml::encode($data->W); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('L')); ?>:</b>
	<?php echo CHtml::encode($data->L); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ERA')); ?>:</b>
	<?php echo CHtml::encode($data->ERA); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('G')); ?>:</b>
	<?php echo CHtml::encode($data->G); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('GS')); ?>:</b>
	<?php echo CHtml::encode($data->GS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SV')); ?>:</b>
	<?php echo CHtml::encode($data->SV); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SVO')); ?>:</b>
	<?php echo CHtml::encode($data->SVO); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('IP')); ?>:</b>
	<?php echo CHtml::encode($data->IP); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('H')); ?>:</b>
	<?php echo CHtml::encode($data->H); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('R')); ?>:</b>
	<?php echo CHtml::encode($data->R); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ER')); ?>:</b>
	<?php echo CHtml::encode($data->ER); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('HR')); ?>:</b>
	<?php echo CHtml::encode($data->HR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('BB')); ?>:</b>
	<?php echo CHtml::encode($data->BB); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SO')); ?>:</b>
	<?php echo CHtml::encode($data->SO); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('AVG')); ?>:</b>
	<?php echo CHtml::encode($data->AVG); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('WHIP')); ?>:</b>
	<?php echo CHtml::encode($data->WHIP); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CG')); ?>:</b>
	<?php echo CHtml::encode($data->CG); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SHO')); ?>:</b>
	<?php echo CHtml::encode($data->SHO); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('HB')); ?>:</b>
	<?php echo CHtml::encode($data->HB); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('IBB')); ?>:</b>
	<?php echo CHtml::encode($data->IBB); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('GF')); ?>:</b>
	<?php echo CHtml::encode($data->GF); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('HLD')); ?>:</b>
	<?php echo CHtml::encode($data->HLD); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('GIDP')); ?>:</b>
	<?php echo CHtml::encode($data->GIDP); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('GO')); ?>:</b>
	<?php echo CHtml::encode($data->GO); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('AO')); ?>:</b>
	<?php echo CHtml::encode($data->AO); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('WP')); ?>:</b>
	<?php echo CHtml::encode($data->WP); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('BK')); ?>:</b>
	<?php echo CHtml::encode($data->BK); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SB')); ?>:</b>
	<?php echo CHtml::encode($data->SB); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CS')); ?>:</b>
	<?php echo CHtml::encode($data->CS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PK')); ?>:</b>
	<?php echo CHtml::encode($data->PK); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TBF')); ?>:</b>
	<?php echo CHtml::encode($data->TBF); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NP')); ?>:</b>
	<?php echo CHtml::encode($data->NP); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('WPCT')); ?>:</b>
	<?php echo CHtml::encode($data->WPCT); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('GO_AO')); ?>:</b>
	<?php echo CHtml::encode($data->GO_AO); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('OBP')); ?>:</b>
	<?php echo CHtml::encode($data->OBP); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SLG')); ?>:</b>
	<?php echo CHtml::encode($data->SLG); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('OPS')); ?>:</b>
	<?php echo CHtml::encode($data->OPS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('K_9')); ?>:</b>
	<?php echo CHtml::encode($data->K_9); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('BB_9')); ?>:</b>
	<?php echo CHtml::encode($data->BB_9); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('K_BB')); ?>:</b>
	<?php echo CHtml::encode($data->K_BB); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('P_IP')); ?>:</b>
	<?php echo CHtml::encode($data->P_IP); ?>
	<br />

	*/ ?>

</div>