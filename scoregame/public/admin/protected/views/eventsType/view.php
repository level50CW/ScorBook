<?php
/* @var $this EventsTypeController */
/* @var $model EventsType */

$this->breadcrumbs=array(
	'Events Types'=>array('index'),
	$model->Name,
);

$this->menu=array(
	array('label'=>'List EventsType', 'url'=>array('index')),
	array('label'=>'Create EventsType', 'url'=>array('create')),
	array('label'=>'Update EventsType', 'url'=>array('update', 'id'=>$model->idevents_type)),
	array('label'=>'Delete EventsType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idevents_type),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EventsType', 'url'=>array('admin')),
);
?>

<h1>View EventsType #<?php echo $model->idevents_type; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idevents_type',
		'Name',
	),
)); ?>
