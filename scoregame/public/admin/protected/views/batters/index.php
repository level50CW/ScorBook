<?php
/* @var $this BattersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Batters',
);

$this->menu=array(
	array('label'=>'Create Batters', 'url'=>array('create')),
	array('label'=>'Manage Batters', 'url'=>array('admin')),
);
?>

<h1>Batters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
