<?php
/* @var $this LineupController */
/* @var $data Lineup */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('idlineup')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->idlineup), array('view', 'id' => $data->idlineup)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('Inning')); ?>:</b>
    <?php echo CHtml::encode($data->Inning); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('Games_idgame')); ?>:</b>
    <?php echo CHtml::encode($data->Games_idgame); ?>
    <br/>


</div>