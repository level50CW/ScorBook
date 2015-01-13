<?php
/* @var $this StatspitchingController */
/* @var $model Statspitching */

$this->breadcrumbs=array(
	'Statspitchings'=>array('index'),
	$model->idstatspit,
);

$this->menu=array(
	array('label'=>'List Statspitching', 'url'=>array('index')),
	array('label'=>'Create Statspitching', 'url'=>array('create')),
	array('label'=>'Update Statspitching', 'url'=>array('update', 'id'=>$model->idstatspit)),
	array('label'=>'Delete Statspitching', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idstatspit),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Statspitching', 'url'=>array('admin')),
);
?>

<h1>View Statspitching #<?php echo $model->idstatspit; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idstatspit',
		'Players_idplayer',
		'Games_idgame',
		'W',
		'L',
		'ERA',
		'G',
		'GS',
		'SV',
		'SVO',
		'IP',
		'H',
		'R',
		'ER',
		'HR',
		'BB',
		'SO',
		'AVG',
		'WHIP',
		'CG',
		'SHO',
		'HB',
		'IBB',
		'GF',
		'HLD',
		'GIDP',
		'GO',
		'AO',
		'WP',
		'BK',
		'SB',
		'CS',
		'PK',
		'TBF',
		'NP',
		'WPCT',
		'GO_AO',
		'OBP',
		'SLG',
		'OPS',
		'K_9',
		'BB_9',
		'K_BB',
		'P_IP',
	),
)); ?>
