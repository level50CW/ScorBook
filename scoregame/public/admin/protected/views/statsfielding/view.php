<?php
/* @var $this StatsfieldingController */
/* @var $model Statsfielding */

$this->breadcrumbs=array(
	'Statsfieldings'=>array('index'),
	$model->Idstatsfield,
);

$this->menu=array(
	array('label'=>'List Statsfielding', 'url'=>array('index')),
	array('label'=>'Create Statsfielding', 'url'=>array('create')),
	array('label'=>'Update Statsfielding', 'url'=>array('update', 'id'=>$model->Idstatsfield)),
	array('label'=>'Delete Statsfielding', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Idstatsfield),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Statsfielding', 'url'=>array('admin')),
);
?>

<h1>View Statsfielding #<?php echo $model->Idstatsfield; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Idstatsfield',
		'Players_idplayer',
		'Games_idgames',
		'G',
		'GS',
		'INN',
		'TC',
		'PO',
		'A',
		'E',
		'DP',
		'SB',
		'CS',
		'SBPCT',
		'PB',
		'C_WP',
		'FPCT',
		'RF',
	),
)); ?>
