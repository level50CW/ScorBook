<?php
/* @var $this LineupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Lineups',
);

$this->menu = array(
    array('label' => 'Create Lineup', 'url' => array('create')),
    array('label' => 'Manage Lineup', 'url' => array('admin')),
);
?>

<h1>Lineups</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>
