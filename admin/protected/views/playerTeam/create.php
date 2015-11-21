<?php
/* @var $this PlayerTeamController */
/* @var $model PlayerTeam */

$this->breadcrumbs=array(
	'Player Teams'=>array('index'),
	'Create',
);

?>

<h1>Create PlayerTeam</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>