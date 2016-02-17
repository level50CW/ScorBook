<?php
/* @var $this RunsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Runs',
);

$this->menu=array(
	array('label'=>'Create Runs', 'url'=>array('create')),
	array('label'=>'Manage Runs', 'url'=>array('admin')),
);
?>

<h1>Runs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
