<?php
/* @var $this EventsController */
/* @var $model Events */

$this->breadcrumbs=array(
	'Events'=>array('index'),
	$model->idevents,
);

$this->menu=array(
	array('label'=>'List Events', 'url'=>array('index')),
	array('label'=>'Create Events', 'url'=>array('create')),
	array('label'=>'Update Events', 'url'=>array('update', 'id'=>$model->idevents)),
	array('label'=>'Delete Events', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idevents),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Events', 'url'=>array('admin')),
);
?>

<h1>View Events #<?php echo $model->idevents; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'idevents',
		'Comment',
		'Lineup_idlineup',
		'Events_type_idevents_type',
		'Inning',
	),
)); ?>
