<?php
/* @var $this BattersController */
/* @var $model Batters */

$this->breadcrumbs=array(
	'Batters'=>array('index'),
	$model->idbatter=>array('view','id'=>$model->idbatter),
	'Update',
);

$this->menu=array(
	array('label'=>'List Batters', 'url'=>array('index')),
	array('label'=>'Create Batters', 'url'=>array('create')),
	array('label'=>'View Batters', 'url'=>array('view', 'id'=>$model->idbatter)),
	array('label'=>'Manage Batters', 'url'=>array('admin')),
);
?>

<h1>Update Batters <?php echo $model->idbatter; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>