<?php
/* @var $this LeagueController */
/* @var $model League */

$this->breadcrumbs=array(
	'Leagues'=>array('index'),
	$model->Name,
);

$this->menu=array(
	array('label'=>'List League', 'url'=>array('index')),
	array('label'=>'Create League', 'url'=>array('create')),
	array('label'=>'Update League', 'url'=>array('update', 'id'=>$model->idleague)),
	array('label'=>'Delete League', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idleague),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage League', 'url'=>array('admin')),
);
?>

<h1>View League #<?php echo $model->idleague; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idleague',
		'Name',
	),
)); ?>
