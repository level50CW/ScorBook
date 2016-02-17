<?php
/* @var $this RunsController */
/* @var $model Runs */

$this->breadcrumbs=array(
	'Runs'=>array('index'),
	$model->idrun=>array('view','id'=>$model->idrun),
	'Update',
);

$this->menu=array(
	array('label'=>'List Runs', 'url'=>array('index')),
	array('label'=>'Create Runs', 'url'=>array('create')),
	array('label'=>'View Runs', 'url'=>array('view', 'id'=>$model->idrun)),
	array('label'=>'Manage Runs', 'url'=>array('admin')),
);
?>

<h1>Update Runs <?php echo $model->idrun; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>