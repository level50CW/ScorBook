<?php
/* @var $this StatshittingController */
/* @var $model Statshitting */

$this->breadcrumbs=array(
	'Statshittings'=>array('index'),
	$model->idstatshit,
);

$this->menu=array(
	array('label'=>'List Statshitting', 'url'=>array('index')),
	array('label'=>'Create Statshitting', 'url'=>array('create')),
	array('label'=>'Update Statshitting', 'url'=>array('update', 'id'=>$model->idstatshit)),
	array('label'=>'Delete Statshitting', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idstatshit),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Statshitting', 'url'=>array('admin')),
);
?>

<h1>View Statshitting #<?php echo $model->idstatshit; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idstatshit',
		'Players_idplayer',
		'Games_idgame',
		'G',
		'AB',
		'R',
		'H',
		'v2B',
		'v3B',
		'HR',
		'RBI',
		'BB',
		'SO',
		'SB',
		'CS',
		'AVG',
		'OBP',
		'SLG',
		'OPS',
		'IBB',
		'HBP',
		'SAC',
		'SF',
		'TB',
		'XBH',
		'GDP',
		'GO',
		'AO',
		'GO_AO',
		'NP',
		'PA',
	),
)); ?>
