<?php
/* @var $this GameOfficialsController */
/* @var $model GameOfficials */

$this->breadcrumbs=array(
	'Game Officials'=>array('index'),
	$model->idGameOfficials,
);

$this->menu=array(
	array('label'=>'List GameOfficials', 'url'=>array('index')),
	array('label'=>'Create GameOfficials', 'url'=>array('create')),
	array('label'=>'Update GameOfficials', 'url'=>array('update', 'id'=>$model->idGameOfficials)),
	array('label'=>'Delete GameOfficials', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idGameOfficials),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GameOfficials', 'url'=>array('admin')),
);
?>

<h1>View GameOfficials #<?php echo $model->idGameOfficials; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'idGameOfficials',
		'Games_idgame',
		'Officials_idofficials',
		'Position',
	),
)); ?>
