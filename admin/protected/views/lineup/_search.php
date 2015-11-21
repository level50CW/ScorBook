<?php
/* @var $this LineupController */
/* @var $model Lineup */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>

    <div class="row">
        <?php echo $form->label($model, 'idlineup'); ?>
        <?php echo $form->textField($model, 'idlineup'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Inning'); ?>
        <?php echo $form->textField($model, 'Inning'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'Games_idgame'); ?>
        <?php echo $form->textField($model, 'Games_idgame'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->