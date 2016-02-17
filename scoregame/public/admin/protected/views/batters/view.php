<?php
/* @var $this BattersController */
/* @var $model Batters */

$this->breadcrumbs=array(
	'Batters'=>array('index'),
	$model->idbatter,
);

$this->menu=array(
	array('label'=>'List Batters', 'url'=>array('index')),
	array('label'=>'Create Batters', 'url'=>array('create')),
	array('label'=>'Update Batters', 'url'=>array('update', 'id'=>$model->idbatter)),
	array('label'=>'Delete Batters', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idbatter),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Batters', 'url'=>array('admin')),
);
?>

<h1>View Batters #<?php echo $model->idbatter; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idbatter',
		'Position',
		'Players_idplayer',
		'Number',
		'Batterscol',
	),
)); ?>
