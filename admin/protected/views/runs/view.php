<?php
/* @var $this RunsController */
/* @var $model Runs */

$this->breadcrumbs=array(
	'Runs'=>array('index'),
	$model->idrun,
);

$this->menu=array(
	array('label'=>'List Runs', 'url'=>array('index')),
	array('label'=>'Create Runs', 'url'=>array('create')),
	array('label'=>'Update Runs', 'url'=>array('update', 'id'=>$model->idrun)),
	array('label'=>'Delete Runs', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idrun),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Runs', 'url'=>array('admin')),
);
?>

<h1>View Runs #<?php echo $model->idrun; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idrun',
		'teams_idteam',
		'inning1',
		'inning2',
		'inning3',
		'inning4',
		'inning5',
		'inning6',
		'inning7',
		'inning8',
		'inning9',
		'R',
		'H',
		'E',
		'games_idgame',
	),
)); ?>
