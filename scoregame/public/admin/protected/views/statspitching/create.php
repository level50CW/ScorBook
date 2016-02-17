<?php
/* @var $this StatspitchingController */
/* @var $model Statspitching */

$this->breadcrumbs=array(
	'Statspitchings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Statspitching', 'url'=>array('index')),
	array('label'=>'Manage Statspitching', 'url'=>array('admin')),
);
?>

<h1>Create Statspitching</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>