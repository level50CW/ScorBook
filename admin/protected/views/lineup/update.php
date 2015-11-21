<?php
/* @var $this LineupController */
/* @var $model Lineup */

$this->breadcrumbs = array(
    'Lineups' => array('index'),
    $model->idlineup => array('view', 'id' => $model->idlineup),
    'Update',
);

$this->menu = array(
    array('label' => 'List Lineup', 'url' => array('index')),
    array('label' => 'Create Lineup', 'url' => array('create')),
    array('label' => 'View Lineup', 'url' => array('view', 'id' => $model->idlineup)),
    array('label' => 'Manage Lineup', 'url' => array('admin')),
);
?>

    <h1>Update Lineup <?php echo $model->idlineup; ?></h1>

    <div id="redbar"></div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>