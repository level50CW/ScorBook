<?php
/* @var $this OfficialsController */
/* @var $model Officials */

$this->breadcrumbs=array(
	'Officials'=>array('index'),
	$model->Name=>array('view','id'=>$model->idofficials),
	'Update',
);

$this->menu=array(
	array('label'=>'List Officials', 'url'=>array('index')),
	array('label'=>'Create Officials', 'url'=>array('create')),
	array('label'=>'View Officials', 'url'=>array('view', 'id'=>$model->idofficials)),
	array('label'=>'Manage Officials', 'url'=>array('admin')),
);
?>

<h1>Update Officials <?php echo $model->idofficials; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>