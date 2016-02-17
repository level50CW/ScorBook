<?php
/* @var $this RunsController */
/* @var $model Runs */

$this->breadcrumbs=array(
	'Runs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Runs', 'url'=>array('index')),
	array('label'=>'Manage Runs', 'url'=>array('admin')),
);
?>

<h1>Create Runs</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>