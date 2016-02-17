<?php
/* @var $this LineupController */
/* @var $model Lineup */

$this->breadcrumbs = array(
    'Lineups' => array('index'),
    $model->idlineup,
);

$this->menu = array(
    array('label' => 'List Lineup', 'url' => array('index')),
    array('label' => 'Create Lineup', 'url' => array('create')),
    array('label' => 'Update Lineup', 'url' => array('update', 'id' => $model->idlineup)),
    array('label' => 'Delete Lineup', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->idlineup), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Lineup', 'url' => array('admin')),
);
?>

<h1>View Lineup #<?php echo $model->idlineup; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'idlineup',
        'Inning',
        'Games_idgame',
    ),
)); ?>
