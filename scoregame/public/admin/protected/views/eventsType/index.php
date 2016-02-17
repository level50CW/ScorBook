<?php
/* @var $this EventsTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Events Types',
);

$this->menu=array(
	array('label'=>'Create EventsType', 'url'=>array('create')),
	array('label'=>'Manage EventsType', 'url'=>array('admin')),
);
?>

<h1>Events Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
