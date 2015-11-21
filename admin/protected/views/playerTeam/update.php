<?php
/* @var $this PlayerTeamController */
/* @var $model PlayerTeam */

$this->breadcrumbs=array(
	'Player Teams'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>Update PlayerTeam <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>