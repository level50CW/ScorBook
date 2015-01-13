<?php
/* @var $this StatshittingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Statshittings',
);

$this->menu=array(
	array('label'=>'Create Statshitting', 'url'=>array('create')),
	array('label'=>'Manage Statshitting', 'url'=>array('admin')),
);
?>

<h1>Statshittings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
