<?php
/* @var $this EventsTypeController */
/* @var $model EventsType */

$this->breadcrumbs=array(
	'Events Types'=>array('index'),
	$model->Name=>array('view','id'=>$model->idevents_type),
	'Update',
);

$this->menu=array(
	array('label'=>'List EventsType', 'url'=>array('index')),
	array('label'=>'Create EventsType', 'url'=>array('create')),
	array('label'=>'View EventsType', 'url'=>array('view', 'id'=>$model->idevents_type)),
	array('label'=>'Manage EventsType', 'url'=>array('admin')),
);
?>

<h1>Update EventsType <?php echo $model->idevents_type; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>