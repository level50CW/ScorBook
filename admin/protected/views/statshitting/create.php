<?php
/* @var $this StatshittingController */
/* @var $model Statshitting */

$this->breadcrumbs=array(
	'Statshittings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Statshitting', 'url'=>array('index')),
	array('label'=>'Manage Statshitting', 'url'=>array('admin')),
);
?>

<h1>Create Statshitting</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>