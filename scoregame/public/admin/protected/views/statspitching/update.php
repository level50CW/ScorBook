<?php
/* @var $this StatspitchingController */
/* @var $model Statspitching */

$this->breadcrumbs=array(
	'Statspitchings'=>array('index'),
	$model->idstatspit=>array('view','id'=>$model->idstatspit),
	'Update',
);

$this->menu=array(
	array('label'=>'List Statspitching', 'url'=>array('index')),
	array('label'=>'Create Statspitching', 'url'=>array('create')),
	array('label'=>'View Statspitching', 'url'=>array('view', 'id'=>$model->idstatspit)),
	array('label'=>'Manage Statspitching', 'url'=>array('admin')),
);
?>

<h1>Update Statspitching <?php echo $model->idstatspit; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>