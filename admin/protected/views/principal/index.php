<?php
/* @var $this DivisionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Divisions',
);

$this->menu=array(
	array('label'=>'Create Division', 'url'=>array('create')),
	array('label'=>'Manage Division', 'url'=>array('admin')),
);
?>

<h1>Divisions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
