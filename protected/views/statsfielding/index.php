<?php
/* @var $this StatsfieldingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Statsfieldings',
);

$this->menu=array(
	array('label'=>'Create Statsfielding', 'url'=>array('create')),
	array('label'=>'Manage Statsfielding', 'url'=>array('admin')),
);
?>

<h1>Statsfieldings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
