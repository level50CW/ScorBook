<?php
/* @var $this EventsTypeController */
/* @var $model EventsType */

$this->breadcrumbs=array(
	'Events Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EventsType', 'url'=>array('index')),
	array('label'=>'Manage EventsType', 'url'=>array('admin')),
);
?>

<h1>Create EventsType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>