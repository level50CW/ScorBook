<?php
/* @var $this LeagueController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Leagues',
);

$this->menu=array(
	array('label'=>'Create League', 'url'=>array('create')),
	array('label'=>'Manage League', 'url'=>array('admin')),
);
?>

<h1>Leagues</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
