<?php
/* @var $this OfficialsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Officials',
);

$this->menu=array(
	array('label'=>'Create Officials', 'url'=>array('create')),
	array('label'=>'Manage Officials', 'url'=>array('admin')),
);
?>

<h1>Officials</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
