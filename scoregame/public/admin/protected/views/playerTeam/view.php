<?php
/* @var $this PlayerTeamController */
/* @var $model PlayerTeam */

$this->breadcrumbs=array(
	'Player Teams'=>array('index'),
	$model->id,
);

?>

<h1>View PlayerTeam #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'Players_idplayer',
		'Teams_idteam',
		'Date',
	),
)); ?>
