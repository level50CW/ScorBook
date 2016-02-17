<?php
/* @var $this BattersController */
/* @var $model Batters */

$this->breadcrumbs=array(
	'Batters'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Batters', 'url'=>array('index')),
	array('label'=>'Manage Batters', 'url'=>array('admin')),
);
?>

<h1>Create Batters</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>