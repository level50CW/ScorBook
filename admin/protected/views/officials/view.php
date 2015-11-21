<?php
/* @var $this OfficialsController */
/* @var $model Officials */

$this->breadcrumbs=array(
	'Officials'=>array('index'),
	$model->Name,
);

$this->menu=array(
	array('label'=>'List Officials', 'url'=>array('index')),
	array('label'=>'Create Officials', 'url'=>array('create')),
	array('label'=>'Update Officials', 'url'=>array('update', 'id'=>$model->idofficials)),
	array('label'=>'Delete Officials', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->idofficials),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Officials', 'url'=>array('admin')),
);
?>

<h1>View Officials #<?php echo $model->idofficials; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'idofficials',
		'Name',
		'Lastname',
	),
)); ?>
