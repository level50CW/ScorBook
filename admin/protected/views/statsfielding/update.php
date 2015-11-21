<?php
/* @var $this StatsfieldingController */
/* @var $model Statsfielding */

$this->breadcrumbs=array(
	'Statsfieldings'=>array('index'),
	$model->Idstatsfield=>array('view','id'=>$model->Idstatsfield),
	'Update',
);

$this->menu=array(
	array('label'=>'List Statsfielding', 'url'=>array('index')),
	array('label'=>'Create Statsfielding', 'url'=>array('create')),
	array('label'=>'View Statsfielding', 'url'=>array('view', 'id'=>$model->Idstatsfield)),
	array('label'=>'Manage Statsfielding', 'url'=>array('admin')),
);
?>

<h1>Update Statsfielding <?php echo $model->Idstatsfield; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>