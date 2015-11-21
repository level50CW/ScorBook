<?php
/* @var $this StatsfieldingController */
/* @var $model Statsfielding */

$this->breadcrumbs=array(
	'Statsfieldings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Statsfielding', 'url'=>array('index')),
	array('label'=>'Manage Statsfielding', 'url'=>array('admin')),
);
?>

<h1>Create Statsfielding</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>