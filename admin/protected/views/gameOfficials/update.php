<?php
/* @var $this GameOfficialsController */
/* @var $model GameOfficials */

$this->breadcrumbs=array(
	'Game Officials'=>array('index'),
	$model->idGameOfficials=>array('view','id'=>$model->idGameOfficials),
	'Update',
);

$this->menu=array(
	array('label'=>'List GameOfficials', 'url'=>array('index')),
	array('label'=>'Create GameOfficials', 'url'=>array('create')),
	array('label'=>'View GameOfficials', 'url'=>array('view', 'id'=>$model->idGameOfficials)),
	array('label'=>'Manage GameOfficials', 'url'=>array('admin')),
);
?>

<h1>Update GameOfficials <?php echo $model->idGameOfficials; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>