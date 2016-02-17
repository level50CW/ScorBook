<?php
/* @var $this OfficialsController */
/* @var $model Officials */

$this->breadcrumbs=array(
	'Officials'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Officials', 'url'=>array('index')),
	array('label'=>'Manage Officials', 'url'=>array('admin')),
);
?>

<h1>Create Officials</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>