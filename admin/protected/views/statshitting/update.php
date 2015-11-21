<?php
/* @var $this StatshittingController */
/* @var $model Statshitting */

$this->breadcrumbs=array(
	'Statshittings'=>array('index'),
	$model->idstatshit=>array('view','id'=>$model->idstatshit),
	'Update',
);

$this->menu=array(
	array('label'=>'List Statshitting', 'url'=>array('index')),
	array('label'=>'Create Statshitting', 'url'=>array('create')),
	array('label'=>'View Statshitting', 'url'=>array('view', 'id'=>$model->idstatshit)),
	array('label'=>'Manage Statshitting', 'url'=>array('admin')),
);
?>

<h1>Update Statshitting <?php echo $model->idstatshit; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>